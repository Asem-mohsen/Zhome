<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RolesController extends Controller
{
    function index(){
        $Roles = Roles::all();
        $adminCounts = [];
        foreach ($Roles as $role) {
            $adminCount = DB::table('admin')->where('RoleID', $role->ID)->count();
            $adminCounts[$role->ID] = $adminCount;
        }
        return view('Admin.Roles.index' , compact('Roles' , 'adminCounts'));
    }
    function view(){
        $Roles = Roles::all();
        return view('Admin.Roles.index' , compact('Roles'));
    }
    function create(){
        return view('Admin.Roles.create');
    }
}