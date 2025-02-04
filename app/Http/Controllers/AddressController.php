<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        return view('address.index', compact('addresses'));
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
}
