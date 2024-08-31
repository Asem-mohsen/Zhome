<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;
use App\Models\ShopOrders;
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;


class UserController extends Controller
{
    use ApiResponse ,HandleImgPath;

    public function index(){

        $Users = User::all();

        return $this->data(compact('Users'), 'Users data retrieved successfully');

    }

    public function profile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $orderCount    = ShopOrders::where('UserID', $user->id)->where('Status' , 1)->count();

        $totalPayments = ShopOrders::where('UserID', $user->id)->where('Status' , 1)->sum('TotalAfterSaving');

        $recommededProducts = Product::all();

        $data = [
            'user' => $user,
            'orderCount' => $orderCount,
            'totalPayments' => $totalPayments,
            'recommended-products'=> $recommededProducts,
        ];

        return $this->data($data , 'User Retrived Successfully');
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

        return $orderStatistics;

    }

    public function userProfile(User $user)
    {
        $userProducts = $user->products;

        $products = Product::with(['brand', 'platforms', 'subcategory.category', 'sale'])->get();

        $orderStatistics = $this->getUserOrderStatistics($user->id);

        $data = [
            'user' => $user,
            'products' =>$this->transformImagePaths($products),
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
