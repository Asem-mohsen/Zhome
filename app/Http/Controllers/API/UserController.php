<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use App\Models\ShopOrders;
use App\Traits\ApiResponse;


class UserController extends Controller
{
    use ApiResponse;

    public function index(){

        $Users = User::all();

        return $this->data($Users->toArray(), 'Users data retrieved successfully');

    }

    public function profile(User $user){

        $orderCount = ShopOrders::where('UserID', $user->id)->where('Status' , 1)->count();
        
        $totalPayments  = ShopOrders::where('UserID', $user->id)->where('Status' , 1)->sum('TotalAfterSaving');

        $data = [
            'user' => $user,
            'orderCount' => $orderCount,
            'totalPayments' => $totalPayments
        ];

        return $this->data($data, 'User data profile retrieved successfully');

    }

    public function getUserOrderStatistics($userId)
    {
        $orderStatistics = DB::table('orders')
            ->select(
                'UserID',
                DB::raw('MIN(created_at) as MinOrderDate'),
                DB::raw('COUNT(ID) as TotalNumberOfOrders')
            )
            ->where('UserID', $userId)
            ->groupBy('UserID')
            ->first();

        return $this->data($orderStatistics, 'User order Statistics retrieved successfully');

    }

    public function userProfile(User $user)
    {
        $userProducts = $user->products;

        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->get();

        $orderStatistics = $this->getUserOrderStatistics($user->id);
        
        $data = [
            'user' => $user,
            'products' => $products,
            'userProducts' => $userProducts,
            'orderStatistics'=> $orderStatistics
        ];

        return $this->data($data, 'User data profile retrieved successfully');

    }

    public function edit(User $user)
    {

        return $this->data($user->toArray(), 'user retrieved successfully');
        
    }

    public function update(User $user)
    {

    }

    public function destroy(User $user)
    {

    }
}
