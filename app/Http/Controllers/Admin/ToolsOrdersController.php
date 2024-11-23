<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ToolOrder;

class ToolsOrdersController extends Controller
{
    public function index()
    {
        $orders = ToolOrder::with(['option'])->get();

        return view('Admin.Orders.Tools.index', compact('orders'));
    }

    public function show(ToolOrder $toolsorder)
    {
        $order = $toolsorder->load(['toolCategories' ,'option' ,'platforms' , 'country', 'city']);

        return view('Admin.Orders.Tools.show', compact('order'));
    }

    public function destroy(ToolOrder $toolsorder)
    {
        $toolsorder->delete();

        toastr()->success( 'Tools order deleted successfully!');

        return redirect()->route('Orders.ToolsOrders.index');
    }
}
