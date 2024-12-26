<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddAdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        $admins = User::with(['role', 'address', 'phones'])
            ->whereHas('role', function ($query) {
                $query->where('role', '!=', 'user');
            })
            ->get();

        return successResponse($admins->toArray() , message:'Admins retrieved successfully');
    }

    public function profile(User $user)
    {
        $user->load(['role', 'address', 'phones']);

        return successResponse($user->toArray() , message:'Admin profile retrieved successfully');
    }

    public function create()
    {
        $roles = Role::all();

        return successResponse($roles->toArray() , message:'Roles for admin creation retrieved successfully');
    }

    public function store(AddAdminRequest $request)
    {
        $data = $request->except('_token', '_method');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => $data['role_id'],
            'zip_code' => $data['zip_code'] ?? null,
            'is_admin' => true,
        ]);

        if (! empty($data['phone'])) {
            $user->phones()->create(['phone' => $data['phone']]);
        }
        if (! empty($data['phone_2'])) {
            $user->phones()->create(['phone' => $data['phone_2']]);
        }

        // Create address record
        $user->address()->create([
            'address' => $data['address'],
            'country' => $data['country'],
            'city' => $data['city'],
        ]);

        return successResponse(message:'Admin Added Successfully');
    }

    public function edit(User $user)
    {
        $user->load('role');

        $roles = Role::all();

        $data = [
            'admin' => $user,
            'roles' => $roles,
        ];

        return successResponse($data, message:'Admin data for editing retrieved successfully');
    }

    public function update(AdminUpdateRequest $request, User $user)
    {
        $data = $request->except('_token', '_method');

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role_id'],
            'zip_code' => $data['zip_code'],
        ]);

        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'street_address' => $data['street_address'],
                'floor' => $data['floor'],
                'apartment' => $data['apartment'],
                'building' => $data['building'],
            ]
        );

        if (! empty($data['phones'])) {
            foreach ($data['phones'] as $phone) {
                $user->phones()->updateOrCreate(
                    ['user_id' => $user->id, 'phone' => $phone], // Condition to find or add each phone
                    ['phone' => $phone]
                );
            }
        }

        return successResponse(message:'Admin Updated Successfully');
    }

    public function destroy(Request $request, User $user)
    {

        try {
            $user->delete();

            return successResponse(message:'Admin Deleted Successfully');

        } catch (\Exception $e) {
            return failureResponse(message:'Failed to delete Admin');
        }

    }
}
