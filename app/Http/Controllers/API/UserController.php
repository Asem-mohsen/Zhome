<?php

namespace App\Http\Controllers\API;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Models\{ Product, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['address', 'phones', 'role'])
            ->whereHas('role', function ($query) {
                $query->where('role', 'user');
            })->get();

        return successResponse(compact('users'), 'Users data retrieved successfully');
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $user->load(['phones', 'address', 'products']);

        $orderCount = User::withCount('orders')->where('status', 'paid')->get();

        $products = Product::all();

        $data = [
            'user' => $user,
            'orderCount' => $orderCount,
            'recommended-products' => $products,
        ];
        return successResponse($data, 'User Retrived Successfully');
    }

    public function edit(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        return successResponse(compact('user'), 'user retrieved successfully');
    }

    public function update(UpdateUserProfileRequest $request)
    {
        $userData = Auth::guard('sanctum')->user();

        $data = $request->except('_method', 'token');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        User::where('id', $userData->id)->update($data);

        $user = User::where('id', $userData->id)->first();

        return successResponse(compact('user'), 'user updated successfully');
    }

    public function deactivate(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $expirationDate = now()->addMonth();

        $updated = [
            'status' => StatusEnum::DISACTIVE->value,
            'deleted_at' => now(),
            'reactivation_date' => $expirationDate,
        ];

        User::where('id', $user->id)->update($updated);

        return successResponse(message:'User Account Deactivated Successfully, It will be reactivated on '.$expirationDate->toDateString());
    }

    public function destroy(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        $updated = [
            'status' => StatusEnum::DELETED->value, //Deleted
            'deleted_at' => now(),
        ];

        User::where('id', $user->id)->update($updated);

        return successResponse(message:'User Account Deleted Successfully');
    }
}
