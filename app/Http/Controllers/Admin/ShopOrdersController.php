<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\User;
use App\Models\Product;
use App\Models\Payments;

class ShopOrdersController extends Controller
{
    public function index(){
        $orders = ShopOrders::with(['transaction', 'promocode', 'user' ,'product'])->Where('UserID','!=', NULL)->get();

        // Count
        $totalOrders  = ShopOrders::all()->count();
        $totalCash    = ShopOrders::whereHas('transaction', function($query) {
                                            $query->where('source_data_type', 'Cash On Delivery');
                                    })->count();
        $totalCards    = ShopOrders::whereHas('transaction', function($query) {
                                            $query->where('source_data_type', 'card');
                                    })->count();
        $totalInCarts = ShopOrders::whereNull('TransactionID')->count();
        return view('Admin.Orders.Shop.index' , compact('orders' , 'totalOrders' ,'totalInCarts', 'totalCash' ,'totalCards'));
    }

    public function show(ShopOrders $shoporder){
        $order = $shoporder::with(['transaction', 'promocode', 'user' ,'product'])->first();
        $productHasSale = $order->product->sale ? true : false;
        $prevOrders = ShopOrders::with(['transaction', 'promocode', 'user' ,'product'])->Where('UserID', $order->UserID)->get();

        return view('Admin.Orders.Shop.show' , compact('order','productHasSale', 'prevOrders'));
    }

    public function destroy(ShopOrders $shoporder){
        $shoporder::where('ID' , $shoporder->ID)->delete();
        Payments::where('ID' , $shoporder->TransactionID)->delete();

        return redirect()->route('Orders.ShopOrders.index')->with('success', 'Order Deleted Successfully');
    }
}
