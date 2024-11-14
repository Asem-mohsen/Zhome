<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToolOrder;

class ToolsOrdersController extends Controller
{
    public function index()
    {
        $orders = ToolOrder::with(['user'])->get();

        return view('Admin.Orders.Tools.index', compact('orders'));
    }

    public function show(ToolOrder $toolsorder)
    {
        $order = $toolsorders->load(['user', 'toolsCategories']);

        return view('Admin.Orders.Tools.show', compact('order'));
    }

    public function destroy(ToolsOrder $toolsorder)
    {
        $toolsorder->delete();

        return redirect()->route('Orders.ToolsOrders.index')->with('success', 'Tools Order Deleted Successfully');
    }
}
