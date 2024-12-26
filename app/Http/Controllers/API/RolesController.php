<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\{ User , Role};

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->get();

        return successResponse($roles->toArray(), 'Roles data retrieved successfully');
    }

    public function edit(Role $role)
    {
        $role->load('users');

        $role->withCount('users');

        $data = [
            'role' => $role,
        ];

        return successResponse($data, 'Role data for editing retrieved successfully');
    }

    public function store(AddRoleRequest $request)
    {
        $data = $request->except('_token', '_method');

        Role::create($data);

        return successResponse(message:'Role Created Successfully');
    }

    public function update(AddRoleRequest $request, Role $role)
    {
        $data = $request->except('_token', '_method');

        $role->update($data);

        return successResponse(message:'Role Updated Successfully');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->exists())
        {
            return failureResponse(message:'Cannot delete this role as an users is already associated with it');
        }

        $role->delete();

        return successResponse(message:'Role deleted successfully');

    }
}
