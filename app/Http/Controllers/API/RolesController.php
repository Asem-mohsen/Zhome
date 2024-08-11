<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\Admin;
use App\Models\Roles;
use App\Models\Accessability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ApiResponse;

class RolesController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $Roles = Roles::all();

        foreach ($Roles as $role) {
            // Add a custom property to each role object
            $role->adminCount = DB::table('admin')->where('RoleID', $role->ID)->count();
        }

        $data = [
            'Roles' => $Roles,
        ];

        return $this->data($data, 'Roles data retrieved successfully');
    }

    public function edit(Request $request , Roles $Role){

        $admins = Admin::where('RoleID','=', $Role->ID)->get();

        $accessability = Accessability::where('RoleID', $Role->ID)->first();

        $columnsToExclude = ['ID', 'RoleID', 'updated_at', 'created_at'];

        $checkboxColumns = array_diff(array_keys($accessability->toArray()),$columnsToExclude);

        $adminCount = $admins->count();

        $data = [
            'Role'           => $Role,
            'admins'         => $admins,
            'adminCount'     => $adminCount,
            'checkboxColumns'=>$checkboxColumns,
            'accessability'  =>$accessability,
        ];

        return $this->data($data, 'Role data for editing retrieved successfully');

    }

    public function create(){

        $accessability = Accessability::all();

        $firstItem = $accessability->first();

        $columnNames = $firstItem ? array_keys($firstItem->toArray()) : [];

        $columnsToExclude = ['ID', 'RoleID', 'updated_at', 'created_at'];

        $checkboxColumns = array_diff($columnNames, $columnsToExclude);

        $data = [
            'accessability'  =>$checkboxColumns,
            // 'checkboxColumns'=>$checkboxColumns,
        ];

        return $this->data($data, 'Role data for Creating retrieved successfully');

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

        return $this->success('Role Created Successfully');

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

        return $this->success('Role Updated Successfully');

    }

    public function destroy(Roles $role , Accessability $accessability)
    {

        try {

            $admins = Admin::where('RoleID','=', $role->ID)->count();

            if($admins > 0){

                return $this->error('Cannot delete this role as an admin already associated to it');

            }else{

                Accessability::where('RoleID', $role->ID)->delete();

                $role::where('ID', $role->ID)->delete();

                return $this->success('Role Deleted Successfully');

            }



        } catch (\Exception $e) {

            return $this->error(['delete_error' => $e->getMessage()], 'Failed to delete Role');

        }


    }
}
