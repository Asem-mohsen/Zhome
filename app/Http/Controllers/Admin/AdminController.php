<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddAdminRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index(){

        $Admins = Admin::leftJoin('adminrole', 'admin.RoleID', '=', 'adminrole.ID')->select('admin.*', 'adminrole.Role')->get();
        return view('Admin.Admin.index' , compact('Admins'));
    }
    public function profile(Admin $admin){
        $Roles= Roles::select('Role')->where('ID', $admin->RoleID)->first();
        return view('Admin.Admin.profile', compact('admin','Roles'));
    }

    public function create(){
        $Roles = Roles::all();
        return view('Admin.Admin.create', compact('Roles'));
    }
    public function store(AddAdminRequest $request){
        $data = $request->except('_token','_method','Country');
        $data['Password'] = bcrypt($request->Password);
        Admin::create($data);

        return redirect()->route('Admins.index')->with('success', 'Admin Added Successfully');
    }
    public function edit(Admin $admin){
        $admin = Admin::leftJoin('adminrole', 'admin.RoleID', '=', 'adminrole.ID')
                        ->select('admin.*', 'adminrole.Role')
                        ->where('adminrole.ID', $admin->RoleID)
                        ->where('admin.ID', $admin->ID)
                        ->first();
        $Roles = Roles::all();
        return view('Admin.Admin.edit' ,compact('admin','Roles'));
    }
    public function update(AdminUpdateRequest $request , Admin $admin){
        $data = $request->except('_token','_method');

        $admin::where('ID', $admin->ID)->update($data);

        return redirect()->route('Admins.profile', $admin->ID)->with('success' , 'Admin Updated Successfully');

    }
    public function destroy(Request $request , Admin $admin){

        $admin::where('ID', $admin->ID)->delete();
        return redirect()->route('Admins.index')->with('success', 'Admin Deleted Successfully');
    }
}
