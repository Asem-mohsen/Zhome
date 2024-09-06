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
use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponse;
use App\Traits\HandleImgPath;
use App\Http\Requests\User\UpdateUserProfileRequest;

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
            ->where('Status' , '!=' , '0')
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

    public function userProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $userProducts = $user->products;

        $products = Product::with(['brand', 'platforms', 'subcategory.category', 'sale'])->get();

        $orderCount    = ShopOrders::where('UserID', $user->id)->where('Status' , 1)->count();

        $totalPayments = ShopOrders::where('UserID', $user->id)->where('Status' , 1)->sum('TotalAfterSaving');

        $orderStatistics = $this->getUserOrderStatistics($user->id);

        $data = [
            'user' => $user,
            'userProducts'=> $this->transformImagePaths($userProducts),
            'orderCount'=> $orderCount,
            'totalPayments'=> $totalPayments,
            'products' =>$this->transformImagePaths($products),
            'orderStatistics'=> $orderStatistics,

        ];

        return $this->data($data, 'User data profile retrieved successfully');

    }

    public function edit(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        return $this->data(compact('user'), 'user retrieved successfully');

    }

    public function update(UpdateUserProfileRequest $request)
    {
        $userData = Auth::guard('sanctum')->user();

        $data = $request->except('_method', 'token');

        if ($request->filled('Password')) {
            $data['Password'] = Hash::make($request->input('Password'));
        }

        User::where('id' , $userData->id)->update($data);

        $user = User::where('id' , $userData->id)->first();

        return $this->data(compact('user'), 'user updated successfully');
    }


    public function deactivate(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $expirationDate = now()->addMonth();

        $updated = [
            'Status' => 0, // Deactivated
            'DeletedOn' => now(),
            'reactivationDate' => $expirationDate // Add a column in your users table for this
        ];

        User::where('id', $user->id)->update($updated);

        return $this->success('User Account Deactivated Successfully, It will be reactivated on ' . $expirationDate->toDateString());
    }


    public function destroy(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $updated =[
            'Status' => 0, //Deleted
            'DeletedOn'=> now(),
        ];

        User::where('id' , $user->id)->update($updated);

        return $this->success('User Account Deleted Successfully');
    }
}
