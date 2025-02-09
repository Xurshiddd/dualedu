<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles'])->orderBy('id', 'asc')->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required',
            'phone' => 'required|string|min:9|max:13',
            'password' => 'required|min:6',
            'roles' => 'required|array'
        ]);
        $user = User::create([
            'name' => $request->name,
            'phone' => '+998'.trim($request->phone),
            'password' => Hash::make($request->password),
            'is_student' => $request->is_student ? 1 : 0,
        ]);
        $user->syncRoles($request->roles);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with(['roles'])->findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required',
            'phone' => 'required|string|min:9|max:13',
            'roles' => 'required|array'
        ]);

        $user = User::findOrFail($id);

        // Update password only if provided
        $phone = preg_replace('/\D/', '', $request->phone); // Faqat raqamlarni olish

        if (strlen($phone) == 9) {
            $phone = '998' . $phone;
        }

        if (!str_starts_with($phone, '998')) {
            $phone = '998' . $phone;
        }

        $phone = '+'.$phone;

        $user->update([
            'name' => $request->name,
            'phone' => $phone, // To‘g‘ri formatlangan raqam
            'is_student' => $request->is_student ? 1 : 0,
        ]);

        if (!empty($request->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }
        // Sync roles (remove old ones and assign new ones)
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Remove all roles before deleting the user
        $user->syncRoles([]);

        // Delete the user
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}
