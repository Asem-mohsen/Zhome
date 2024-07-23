<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShopOrders;
use App\Models\User;
use App\Models\Product;
use App\Models\Payments;
use App\Traits\ApiResponse;

class ShopOrdersController extends Controller
{
    use ApiResponse;

    public function index(){

        $orders = ShopOrders::with(['transaction', 'promocode', 'user' ,'product'])->Where('UserID','!=', NULL)->get();

        // Count
        $totalOrders  = ShopOrders::all()->count();
        
        $totalCash    = ShopOrders::whereHas('transaction', function($query) {
                                            $query->where('source_data_type', 'Cash On Delivery');
                                    })->count();
        $totalCards   = ShopOrders::whereHas('transaction', function($query) {
                                            $query->where('source_data_type', 'card');
                                    })->count();
        $totalInCarts = ShopOrders::whereNull('TransactionID')->count();

        $data = [
            'orders'      => $orders,
            'totalOrders' => $totalOrders,
            'totalInCarts'=> $totalInCarts,
            'totalCash'   => $totalCash,
            'totalCards'  => $totalCards
        ];

        return $this->data($data, 'Shop Orders retrieved successfully');

    }

    public function show(ShopOrders $shoporder){

        $order = $shoporder::with(['transaction', 'promocode', 'user' ,'product'])->first();
        
        $productHasSale = $order->product->sale ? true : false;
        
        $prevOrders = ShopOrders::with(['transaction', 'promocode', 'user' ,'product'])->Where('UserID', $order->UserID)->get();

        $data = [
            'order'          => $order,
            'productHasSale' => $productHasSale,
            'prevOrders'     => $prevOrders,
        ];

        return $this->data($data, 'Shop Order retrieved successfully');

    }

    public function destroy(ShopOrders $shoporder){

        try {

            $shoporder::where('ID' , $shoporder->ID)->delete();

            Payments::where('ID' , $shoporder->TransactionID)->delete();

            return $this->success('Order Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Order');
        
        }

    }
}
