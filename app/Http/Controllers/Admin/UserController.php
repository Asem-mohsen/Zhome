<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {

        $users = User::with(['address', 'phones', 'role'])
            ->whereHas('role', function ($query) {
                $query->where('role', 'user');
            })->get();

        return view('Admin.Users.index', compact('users'));
    }

    public function profile(User $user)
    {
        $completedOrders = Order::where('user_id', $user->id)->where('status', OrderStatusEnum::COMPLETED->value);
       
        // Get counts and sums from the query
        $orderCount = $completedOrders->count();
        $totalPayments = $completedOrders->sum('total_amount');

        return view('Admin.Users.profile', get_defined_vars());
    }

    public function getUserOrderStatistics($userId)
    {
        $orderStatistics = Order::withCount('user')->where('user_id', $userId)->groupBy('user_id')->first();

        return $orderStatistics;
    }

    public function userProfile(User $user)
    {
        $userProducts = $user->products;
        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();
        $orderStatistics = $this->getUserOrderStatistics($user->id);

        return view('User.Profile.index', compact('user', 'products', 'userProducts', 'orderStatistics'));
    }

    public function edit(User $user)
    {
        return view('User.Profile.edit', compact('user'));
    }

    public function update(User $user) {}

    public function destroy(User $user) {}
}
