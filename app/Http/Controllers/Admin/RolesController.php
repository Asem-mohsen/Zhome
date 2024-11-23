<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddRoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {

        $roles = Role::withCount('users')->get();

        return view('Admin.Roles.index', compact('roles'));
    }

    public function edit(Request $request, Role $role)
    {

        $role->load('users');

        $role->withCount('users');

        return view('Admin.Roles.edit', compact('role'));
    }

    public function create()
    {
        return view('Admin.Roles.create');
    }

    public function store(AddRoleRequest $request)
    {
        $data = $request->except('_token', '_method');

        Role::create($data);

        toastr()->success(message: 'Role created successfully');

        return redirect()->route('Roles.index');
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->except('_token', '_method');

        $role->update($data);

        toastr()->success(message: 'Role updated successfully');

        return redirect()->route('Roles.edit', $role->id);
    }

    public function destroy(Role $role)
    {

        if ($role->users()->exists()) {

            toastr()->error(message: 'Cannot delete this role as an users is already associated with it');

            return redirect()->route('Roles.index');
        }

        $role->delete();

        toastr()->success(message: 'Role deleted successfully');

        return redirect()->route('Roles.index');

    }
}
