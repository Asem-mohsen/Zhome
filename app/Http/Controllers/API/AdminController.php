<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddAdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class AdminController extends Controller
{
    use ApiResponse;

    public function index(){

        $Admins = Admin::leftJoin('adminrole', 'admin.RoleID', '=', 'adminrole.ID')->select('admin.*', 'adminrole.Role')->get();

        $authenticatedAdmin = Auth::guard('sanctum')->user();
        $data = [
            'admins' => $Admins->toArray(),
            'authenticatedAdmin' => $authenticatedAdmin ? $authenticatedAdmin->toArray() : null,
        ];

        return $this->data($data, 'Admins retrieved successfully');
    }

    public function profile(Admin $admin){

        $Roles= Roles::select('Role')->where('ID', $admin->RoleID)->first();

        $authenticatedAdmin = Auth::guard('sanctum')->user();


        $data = [
            'admin' => $admin,
            'roles' => $Roles,
            'authenticatedAdmin' => $authenticatedAdmin
        ];

        return $this->data($data, 'Admin profile retrieved successfully');
    }

    public function create(){

        $Roles = Roles::all();

        return $this->data(['roles' => $Roles], 'Roles for admin creation retrieved successfully');

    }

    public function store(AddAdminRequest $request){

        $data = $request->except('_token','_method','Country');

        $data['Password'] = bcrypt($request->Password);

        Admin::create($data);

        return $this->success('Admin Added Successfully');
    }

    public function edit(Admin $admin){
        $admin = Admin::with('roles')->where('id' , $admin->id)->first();
        $Roles = Roles::all();
        $data = [
            'admin' => $admin,
            'roles' => $Roles
        ];

        return $this->data($data, 'Admin data for editing retrieved successfully');
    }

    public function update(AdminUpdateRequest $request , Admin $admin){
        $data = $request->except('_token','_method');

        $admin::where('id', $admin->id)->update($data);

        return $this->success('Admin Updated Successfully');

    }

    public function destroy(Request $request , Admin $admin){

        try {
            $admin->delete();

            return $this->success('Admin Deleted Successfully');

        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Admin');

        }

    }
}
