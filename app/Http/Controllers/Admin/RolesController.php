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
    public function index(){
        $Roles = Roles::all();
        $adminCounts = [];
        foreach ($Roles as $role) {
            $adminCount = DB::table('admin')->where('RoleID', $role->ID)->count();
            $adminCounts[$role->ID] = $adminCount;
        }
        return view('Admin.Roles.index' , compact('Roles' , 'adminCounts'));
    }
    public function edit(Request $request , Roles $Role){
        $admins = Admin::where('RoleID','=', $Role->ID)->get();
        $accessability = Accessability::where('RoleID', $Role->ID)->first();
        $columnsToExclude = ['ID', 'RoleID', 'updated_at', 'created_at'];
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
        
        $roleName = $request->Name;
        $role = Roles::create(['Role' => $roleName]);
        
        $checkboxValues = [];
        foreach ($request->except('_token','_method', 'Name') as $key => $value) {
            $checkboxValues[$key] = isset($value) ? 1 : 0;
        }
        
        $data = array_merge($request->except('_token','_method', 'Name'), $checkboxValues);
        $data['RoleID'] = $role->id;
        Accessability::create($data);
        
        return redirect()->route('Roles.index')->with('success', 'Role created successfully');
    }

    public function update(AddRoleRequest $request , Roles $role , Accessability $accessability){
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
    public function destroy(Roles $role , Accessability $accessability){
        
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