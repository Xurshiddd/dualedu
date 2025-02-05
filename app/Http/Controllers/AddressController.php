<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $groups = Group::all();
        $groupId = $request->input('group_id');
        $addresses = Address::with('user')
            ->when($groupId, function ($query, $groupId) {
                return $query->whereHas('user', function ($q) use ($groupId) {
                    $q->whereHas('groups', function ($g) use ($groupId) {
                        $g->where('groups.id', $groupId);
                    });
                });
            })->get();
        return view('address.index', compact('addresses', 'groups', 'groupId'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('address.create', compact('groups'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'company_name' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'long' => 'nullable|string|max:255',
            'lat' => 'nullable|string|max:255',
        ]);

        Address::create([
            'user_id' => $request->user_id,
            'company_name' => $request->company_name,
            'street' => $request->street,
            'number' => $request->number,
            'city' => $request->city,
            'long' => $request->long,
            'lat' => $request->lat,
        ]);

        return redirect()->route('addresses.create')->with('success', 'Address added successfully!');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('addresses.index')->with('success', 'Address deleted successfully!');
    }
}
