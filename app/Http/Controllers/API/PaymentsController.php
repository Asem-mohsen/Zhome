<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{ Payment , Order};
use App\Services\PaymobService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    use ApiResponse;

    protected $paymobService;

    public function __construct(PaymobService $paymobService)
    {
        $this->paymobService = $paymobService;
    }

    public function index()
    {

        $orders = Order::with(['transaction', 'user'])->get();

        $sumOrders = 0;

        foreach ($orders as $transactions) {

            $sumOrders += $transactions->TotalAfterSaving;

        }

        // Amount In Cart
        $ordersInCart = Order::whereNull('TransactionID')->where('Status', '2')->get();

        $sumCart = 0;

        foreach ($ordersInCart as $cart) {

            $sumCart += $cart->TotalAfterSaving;

        }

        $totalCash = Order::whereHas('transaction', function ($query) {
            $query->where('source_data_type', 'Cash On Delivery');
        })->count();
        $totalCards = Order::whereHas('transaction', function ($query) {
            $query->where('source_data_type', 'card');
        })->count();
        $newest = Order::with(['transaction', 'user', 'product'])
            ->whereIn('Status', [1, 0])
            ->whereBetween('created_at', [now()->subDays(4), now()])
            ->orderBy('created_at', 'DESC')
            ->get();

        $past = Order::with(['transaction', 'user', 'product'])
            ->where('Status', 1)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'DESC')
            ->limit(7)
            ->get();

        $data = [
            'orders' => $orders,
            'sumOrders' => $sumOrders,
            'sumCart' => $sumCart,
            'totalCash' => $totalCash,
            'totalCards' => $totalCards,
            'newest' => $newest,
            'past' => $past,
        ];

        return $this->data($data, 'Payments data retrieved successfully');

    }

    public function createPayment(Request $request)
    {
        $order = Order::create([
            'user_id' => $request->user()->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        $authToken = $this->paymobService->authenticate();
        $orderData = $this->paymobService->createOrder($authToken, $order->amount);

        $paymentToken = $this->paymobService->getPaymentToken($orderData['id'], $order->amount, $authToken);

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_token' => $paymentToken,
            'amount' => $order->amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'iframe_url' => "https://accept.paymobsolutions.com/api/acceptance/iframes/{$this->paymobService->iframeId}?payment_token=$paymentToken",
        ]);
    }
}
