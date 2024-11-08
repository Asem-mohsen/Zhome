<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddAdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function index(){

        $admins = User::with(['role', 'address', 'phones'])
                 ->whereHas('role', function ($query) {
                     $query->where('role', '!=', 'user');
                 })
                 ->get();

        return view('Admin.Admin.index' , compact('admins'));
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

    public function store(AddAdminRequest $request){

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

        return redirect()->route('Admins.index')->with('success', 'Admin Added Successfully');
    }

    public function edit(User $user){

        $user->load('role');

        $roles = Role::all();

        return view('Admin.Admin.edit' ,compact('user','roles'));

    }

    public function update(AdminUpdateRequest $request , User $user)
    {
        $data = $request->except('_token','_method');

        $user::update($data);

        return redirect()->route('Admins.profile', $user->id)->with('success' , 'Admin Updated Successfully');

    }

    public function destroy(Request $request , User $user)
    {
        $user->delete();

        return redirect()->route('Admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
