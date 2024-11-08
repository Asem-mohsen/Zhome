<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Accessability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RolesController extends Controller
{
    public function index(){

        $roles = Role::withCount('users')->get();

        return view('Admin.Roles.index' , compact('roles'));
    }

    public function edit(Request $request , Role $role){

        $admins = User::where('role_id','=', $role->id)->get();

        $accessability = Accessability::where('role_id', $role->id)->first();

        $columnsToExclude = ['id', 'role_id', 'updated_at', 'created_at'];

        $checkboxColumns = array_diff(array_keys($accessability->toArray()),$columnsToExclude);

        $adminCount = $admins->count();

        return view('Admin.Roles.edit' , compact('Role' , 'admins' , 'adminCount', 'checkboxColumns' , 'accessability'));
    }

    public function create(){
        $accessability = Accessability::all();
        $firstItem = $accessability->first();
        $columnNames = $firstItem ? array_keys($firstItem->toArray()) : [];
        $columnsToExclude = ['ID', 'RoleID', 'updated_at', 'created_at'];
        $checkboxColumns = array_diff($columnNames, $columnsToExclude);
        return view('Admin.Roles.create' , compact('accessability', 'checkboxColumns'));
    }

    public function store(AddRoleRequest $request){

        $roleName = $request->role;
        $role = Role::create(['role' => $roleName]);

        $checkboxValues = [];
        foreach ($request->except('_token','_method', 'Name') as $key => $value) {
            $checkboxValues[$key] = isset($value) ? 1 : 0;
        }

        $data = array_merge($request->except('_token','_method', 'Name'), $checkboxValues);
        $data['RoleID'] = $role->id;
        Accessability::create($data);

        return redirect()->route('Roles.index')->with('success', 'Role created successfully');
    }

    public function update(AddRoleRequest $request , Role $role , Accessability $accessability){
        $data = $request->except('_token','_method');
        $role->update(['Role'=>$data['Name']]);
        $role::where('ID', $role->ID)->update(['Role'=>$data['Name']]);

        $checkboxValues = [];
        foreach ($request->except('_token','_method', 'Name') as $key => $value) {
            $checkboxValues[$key] = isset($value) ? 1 : 0;
        }

        $accessabilityData = array_merge($request->except('_token','_method', 'Name'), $checkboxValues);
        $accessability::where('RoleID', $role->ID)->update($accessabilityData);

        return redirect()->route('Roles.edit' , $role->ID)->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role , Accessability $accessability){

        $admins = Admin::where('RoleID','=', $role->ID)->count();
        if($admins > 0){
            return redirect()->route('Roles.index')->with('error', 'Cannot delete this role as an admin already associated to it');
        }else{
            Accessability::where('RoleID', $role->ID)->delete();
            $role::where('ID', $role->ID)->delete();
            return redirect()->route('Roles.index')->with('success', 'Role Deleted Successfully');
        }

    }
}
