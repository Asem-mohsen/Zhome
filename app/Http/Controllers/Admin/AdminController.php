<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function index(){
        
        $Admins = DB::table('admin')->leftJoin('adminrole', 'admin.RoleID', '=', 'adminrole.ID')->select('admin.*', 'adminrole.Role')->get();
        return view('Admin.Admin.index' , compact('Admins'));
    }
    public function profile(Admin $admin){
        $Roles= DB::table('adminrole')->select('Role')->where('ID', $admin->RoleID)->first();
        return view('Admin.Admin.profile', compact('admin','Roles'));
    }
}