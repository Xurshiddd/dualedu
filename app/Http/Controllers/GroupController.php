<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }
    public function create()
    {
        $group = new Group();
        $users = User::all();
        return view('groups.create', compact('group', 'users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kurs_num' => 'required|string|max:4',
            'users_id' => 'nullable|array',
            'users_id.*' => 'exists:users,id',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'kurs_num' => $request->kurs_num,
        ]);

        if ($request->has('users_id')) {
            $group->users()->attach($request->users_id);
        }

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

    public function show(Group $group)
    {
        return view('groups.show', compact('group'));
    }
    public function edit(Group $group)
    {
        $users = User::all();
        return view('groups.create', compact('group', 'users'));
    }
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kurs_num' => 'required|string|max:4',
            'users_id' => 'nullable|array',
            'users_id.*' => 'exists:users,id',
        ]);

        $group->update([
            'name' => $request->name,
            'kurs_num' => $request->kurs_num,
        ]);

        if ($request->has('users_id')) {
            $group->users()->sync($request->users_id);
        } else {
            $group->users()->detach();
        }

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }
    public function destroy(Group $group)
    {
        try {
            // Agar guruhning users() bog‘lanishi bo‘lsa, uni ajratamiz (detach)
            $group->users()->detach();

            // Guruhni o‘chiramiz
            $group->delete();

            return redirect()->route('groups.index')->with('success', 'Group deleted!');
        } catch (\Exception $e) {
            return redirect()->route('groups.index')->with('error', 'Something went wrong!');
        }
    }

}
