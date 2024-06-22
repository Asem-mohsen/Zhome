<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Delivery;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $Users = User::all();
        return view('Admin.Users.index', compact('Users'));
    }

    public function profile(User $user){

        return view('Admin.Users.profile', compact('user'));
    }

    public function getUserOrderStatistics($userId)
    {
        $orderStatistics = DB::table('orders')
            ->select(
                'UserID',
                DB::raw('MIN(Date) as MinOrderDate'),
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
        $products = Product::with(['brand', 'platforms', 'subcategory.category'])->all();
        $orderStatistics = $this->getUserOrderStatistics($user->id);
        return view('User.Profile.index', compact('user' , 'products', 'userProducts' ,'orderStatistics'));
    }
    
    public function edit(User $user)
    {
        return view('User.Profile.edit', compact('user'));
    }

    public function update(User $user)
    {

    }

    public function destroy(User $user)
    {
        
    }
}