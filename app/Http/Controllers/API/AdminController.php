<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddAdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class AdminController extends Controller
{
    use ApiResponse;

    public function index(){

        $admins = User::with(['role', 'address', 'phones'])
                    ->whereHas('role', function ($query) {
                        $query->where('role', '!=', 'user');
                    })
                    ->get();

        return $this->data($admins->toArray(), 'Admins retrieved successfully');
    }

    public function profile(User $user)
    {
        $user->load(['role', 'address', 'phones']);

        return $this->data($user->toArray(), 'Admin profile retrieved successfully');
    }

    public function create()
    {
        $roles = Role::all();

        return $this->data($roles->toArray(), 'Roles for admin creation retrieved successfully');
    }

    public function store(AddAdminRequest $request)
    {
        $data = $request->except('_token','_method');

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role_id'  => $data['role_id'],
            'zip_code' => $data['zip_code']  ?? null,
            'is_admin' => true,
        ]);
    
        if (!empty($data['phone'])) {
            $user->phones()->create(['phone' => $data['phone']]);
        }
        if (!empty($data['phone_2'])) {
            $user->phones()->create(['phone' => $data['phone_2']]);
        }
    
        // Create address record
        $user->address()->create([
            'address' => $data['address'],
            'country' => $data['country'],
            'city'    => $data['city'],
        ]);

        return $this->success('Admin Added Successfully');
    }

    public function edit(User $user)
    {
        $user->load('role');

        $roles = Role::all();

        $data = [
            'admin' => $user,
            'roles' => $roles
        ];

        return $this->data($data, 'Admin data for editing retrieved successfully');
    }

    public function update(AdminUpdateRequest $request , User $user)
    {
        $data = $request->except('_token','_method');

        $user::update($data);

        return $this->success('Admin Updated Successfully');

    }

    public function destroy(Request $request , User $user)
    {

        try {
            $user->delete();

            return $this->success('Admin Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Admin');

        }

    }
}
