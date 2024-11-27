<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\{ Order , Payment } ;

class ShopOrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['promotions', 'user', 'product'])->get();

        $totalOrdersCount = $orders->count();

        $pendingOrdersCount = Order::where('status', OrderStatusEnum::PENDING->value)->count();

        $totalCash = Payment::where('status', OrderStatusEnum::CASH_ON_DELIVERY->value)->count();

        $totalCards = Payment::where('status', OrderStatusEnum::CARD->value)->count();

        return view('Admin.Orders.Shop.index', get_defined_vars());
    }

    public function show(Order $order)
    {
        $order->load(['promotions', 'user', 'product', 'orderInstallation']);

        $previousOrders = Order::where('user_id', $order->user_id)
            ->where('id', '<>', $order->id)
            ->with(['promotions', 'product', 'user'])
            ->get();

        return view('Admin.Orders.Shop.show', get_defined_vars());
    }

    public function destroy(Order $order)
    {
        $order->delete();

        toastr()->success(message: 'order deleted successfully!');

        return redirect()->route('Orders.Order.index');
    }
}
