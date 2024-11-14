<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{ Payment , Order} ;
use App\Traits\ApiResponse;

class ShopOrdersController extends Controller
{
    use ApiResponse;

    public function index()
    {

        $orders = Order::with(['transaction', 'promocode', 'user', 'product'])->Where('UserID', '!=', null)->get();

        // Count
        $totalOrders = Order::all()->count();

        $totalCash = Order::whereHas('transaction', function ($query) {
            $query->where('source_data_type', 'Cash On Delivery');
        })->count();
        $totalCards = Order::whereHas('transaction', function ($query) {
            $query->where('source_data_type', 'card');
        })->count();
        $totalInCarts = Order::whereNull('TransactionID')->count();

        $data = [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalInCarts' => $totalInCarts,
            'totalCash' => $totalCash,
            'totalCards' => $totalCards,
        ];

        return $this->data($data, 'Shop Orders retrieved successfully');

    }

    public function show(Order $order)
    {

        $order->load(['transaction', 'promocode', 'user', 'product'])->first();

        $productHasSale = $order->product->sale ? true : false;

        $prevOrders = Order::with(['transaction', 'promocode', 'user', 'product'])->Where('UserID', $order->UserID)->get();

        $data = [
            'order' => $order,
            'productHasSale' => $productHasSale,
            'prevOrders' => $prevOrders,
        ];

        return $this->data($data, 'Shop Order retrieved successfully');

    }

    public function destroy(Order $order)
    {

        try {

            $order->delete();

            Payment::where('id', $order->transation_id)->delete();

            return $this->success('Order Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Order');

        }

    }
}
