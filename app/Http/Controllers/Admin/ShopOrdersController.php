<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\{ Order , Payment } ;
use Illuminate\Support\Facades\DB;

class ShopOrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['promotions', 'user', 'products'])->get();

        $totalOrdersCount = $orders->count();

        $pendingOrdersCount = Order::where('status', OrderStatusEnum::PENDING->value)->count();

        $totalCash = Payment::where('payment_status', OrderStatusEnum::CASH_ON_DELIVERY->value)->count();

        $totalCards = Payment::where('payment_status', OrderStatusEnum::CARD->value)->count();

        return view('Admin.Orders.Shop.index', get_defined_vars());
    }

    public function show(Order $order)
    {
        $order->load(['promotions', 'user', 'products']);

        $previousOrders = Order::where('user_id', $order->user_id)
            ->where('id', '<>', $order->id)
            ->with(['promotions', 'products', 'user'])
            ->get();

        return view('Admin.Orders.Shop.show', get_defined_vars());
    }

    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();
            
            $order->products()->delete();
            
            if ($order->payment) {
                $order->payment->delete();
            }
            
            $order->delete();
            
            DB::commit();
            
            toastr()->success(message: 'Order deleted successfully!');
            
            return redirect()->route('Orders.ShopOrders.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            toastr()->error(message: 'Error deleting order. Please try again.');
            
            return redirect()->back();
        }
    }
}
