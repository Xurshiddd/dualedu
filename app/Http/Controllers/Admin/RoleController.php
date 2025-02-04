<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $role = new Role();
        $permissions = Permission::all();
        return view('roles.create', compact('role', 'permissions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array'
        ]);
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    public function show($id)
    {
        $role = Role::with('permissions')->find($id);
        if (!$role) {
            abort(404, 'Role not found');
        }
        return view('roles.show', compact('role'));
    }
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::all();
        return view('roles.create', compact('role', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'required|array',
        ]);
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'super-admin') {
            return redirect()->route('roles.index')->with('error', 'Cannot delete the super-admin role.');
        }
        $role->syncPermissions([]);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

}
