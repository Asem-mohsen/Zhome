<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\ShopOrders;
use Carbon\Carbon;


class PaymentController extends Controller
{
    public function index(){
        $orders  = ShopOrders::with(['transaction', 'user'])->get();
        $sumOrders = 0;
        foreach($orders as $transactions){
            $sumOrders += $transactions->TotalAfterSaving;
        }

        // Amount In Cart
        $ordersInCart= ShopOrders::whereNull('TransactionID')->where('Status' , '2')->get();
        $sumCart = 0;
        foreach($ordersInCart as $cart){
            $sumCart += $cart->TotalAfterSaving;
        }

        $totalCash = ShopOrders::whereHas('transaction', function($query) {
                                            $query->where('source_data_type', 'Cash On Delivery');
                                    })->count();
        $totalCards = ShopOrders::whereHas('transaction', function($query) {
                                            $query->where('source_data_type', 'card');
                                    })->count();
        $newest = ShopOrders::with(['transaction', 'user', 'product'])
                            ->whereIn('Status', [1, 0])
                            ->whereBetween('created_at', [now()->subDays(4), now()])
                            ->orderBy('created_at', 'DESC')
                            ->get();

        $past = ShopOrders::with(['transaction', 'user', 'product'])
                            ->where('Status', 1)
                            ->where('created_at', '>=', Carbon::now()->subDays(7))
                            ->orderBy('created_at', 'DESC')
                            ->limit(7)
                            ->get();
        return view('Admin.Payments.index' , compact('orders' , 'sumOrders' , 'sumCart' , 'totalCash' , 'totalCards' , 'newest', 'past'));
    }

    public function userPayment()
    {
        return view('User.Payment.checkout');
    }
}
