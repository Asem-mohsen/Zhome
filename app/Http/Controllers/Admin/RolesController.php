<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\Admin;
use App\Models\Roles;
use App\Models\Accessability;
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
    function edit(Request $request , Roles $Role){
        $admins = Admin::where('RoleID','=', $Role->ID)->get();
        $accessability = Accessability::where('RoleID', $Role->ID)->first();
        $adminCount = $admins->count();
        return view('Admin.Roles.edit' , compact('Role' , 'admins' , 'adminCount', 'accessability'));
    }
    
    function create(){
        $accessability = Accessability::all();
        return view('Admin.Roles.create' , compact('accessability'));
    }

    function store(AddRoleRequest $request){
        $roleName = $request->Name;
        $role = Roles::create(['Role' => $roleName]);
        $data = $request->except('_token','_method', 'Name');
        $data['ID'] = $role->ID;
        Accessability::create($data);
        
        return redirect()->route('Admin.Roles.index')->with('success', 'Role created successfully');
    }
}