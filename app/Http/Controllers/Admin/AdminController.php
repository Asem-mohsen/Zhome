<?php

namespace App\Http\Controllers\Admin;

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

        return view('Admin.Admin.index', compact('admins'));
    }

    public function profile(User $user)
    {
        $user->load(['role', 'address', 'phones']);

        return view('Admin.Admin.profile', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('Admin.Admin.create', compact('roles'));
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

        toastr()->success(message: 'Admin created successfully!');

        return redirect()->route('Admins.index')->with('success', 'Admin Added Successfully');
    }

    public function edit(User $user)
    {
        $user->load('role');

        $roles = Role::all();

        return view('Admin.Admin.edit', compact('user', 'roles'));
    }

    public function update(AdminUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();

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

        toastr()->success(message: 'Admin updated successfully!');

        return redirect()->route('Admins.profile', $user->id);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        toastr()->success(message: 'Admin deleted successfully!');

        return redirect()->route('Admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
