<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{ Payment , Order} ;
use App\Enums\OrderStatusEnum;

class ShopOrdersController extends Controller
{
    public function index()
    {

        $orders = Order::with(['transaction', 'promocode', 'user', 'products'])->get();

        $totalOrders = $orders->count();

        $pendingOrdersCount = $orders->where('status', OrderStatusEnum::PENDING->value)->count();

        $totalCash = Payment::where('payment_status', OrderStatusEnum::CASH_ON_DELIVERY->value)->count();

        $totalCards = Payment::where('payment_status', OrderStatusEnum::CARD->value)->count();

        $data = [
            'orders' => $orders,
            'totalOrders' => $totalOrders,
            'totalCarts' => $pendingOrdersCount,
            'totalCash' => $totalCash,
            'totalCards' => $totalCards,
        ];

        return successResponse($data, 'Shop Orders retrieved successfully');
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

        return successResponse($data, 'Shop Order retrieved successfully');
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();

            Payment::where('id', $order->transation_id)->delete();

            return successResponse(message:'Order Deleted Successfully');

        } catch (\Exception $e) {
            return failureResponse(message:'Failed to delete Order');
        }

    }
}
