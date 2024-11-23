<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        // Sum Orders
        $sumOrders = Order::with(['payment', 'user'])->sum('total_amount');

        // Sum In Cart
        $sumCart = Order::where('status', OrderStatusEnum::PENDING->value)->sum('total_amount');

        $totalCash = Order::whereHas('payment', function ($query) {
            $query->where('status', 'cash on delivery');
        })->count();

        $totalCards = Order::whereHas('payment', function ($query) {
            $query->where('status', 'card');
        })->count();

        $newest = Order::with(['payment', 'user', 'product.translations'])
            ->where('status', OrderStatusEnum::COMPLETED->value)
            ->whereBetween('created_at', [now()->subDays(4), now()])
            ->orderBy('created_at', 'desc')
            ->get();

        $past = Order::with(['payment', 'user', 'product'])
            ->where('Status', OrderStatusEnum::COMPLETED->value)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'DESC')
            ->limit(7)
            ->get();

        return view('Admin.Payments.index', get_defined_vars());
    }
}
