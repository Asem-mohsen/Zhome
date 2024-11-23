<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\{ Order , User , ToolOrder, Product};

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::whereHas('role', function ($query) {
                    $query->where('role', 'user');
                })->count();

        $orders = Order::where('status' , OrderStatusEnum::COMPLETED->value)->count();

        $tools = ToolOrder::count();

        $products = Product::count();

        return view('Admin.index', get_defined_vars());
    }
}
