<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissons = Permission::paginate(10);
        return view('permissions.index', compact('permissons'));
    }

    public function create()
    {
        $permission = new Permission();
        return view('permissions.create', compact('permission'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('permissions.create', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Permission::where('id', $id)->update([
            'name' => $request->name
        ]);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }
    public function destroy($id)
    {
        Permission::destroy($id);
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
