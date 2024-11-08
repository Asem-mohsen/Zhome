<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Enums\OrderStatusEnum;

class ShopOrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['promotions', 'user' ,'product'])->get();

        $totalOrdersCount = $orders->count();

        $pendingOrdersCount = Order::where('status', OrderStatusEnum::PENDING->value)->count();

        return view('Admin.Orders.Shop.index' , get_defined_vars());
    }

    public function show(Order $order)
    {
        $order->load(['promotions', 'user' ,'product' , 'orderInstallation']);

        $previousOrders = Order::where('user_id', $order->user_id)
                            ->where('id', '<>', $order->id)
                            ->with(['promotions', 'product','user'])
                            ->get();

        return view('Admin.Orders.Shop.show' ,  get_defined_vars());
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('Orders.Order.index')->with('success', 'Order Deleted Successfully');
    }
}
