<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ToolsOrders;
use App\Models\ToolsCategories;


class ToolsOrdersController extends Controller
{
    public function index(){
        $orders = ToolsOrders::with(['user'])->get();

        return view('Admin.Orders.Tools.index' , compact('orders'));
    }

    public function show(ToolsOrders $toolsorders){
        $order = $toolsorders::with(['user' ,'toolsCategories'])->first();

        return view('Admin.Orders.Tools.show' , compact('order'));
    }

    public function destroy(ToolsOrders $toolsorders){
        ToolsCategories::where('ToolOrderID' , $toolsorders->ID)->delete();
        $toolsorders::where('ID' , $toolsorders->ID)->delete();

        return redirect()->route('Orders.ToolsOrders.index')->with('success', 'Tools Order Deleted Successfully');
    }
}
