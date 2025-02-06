<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\PracticDate;
use Illuminate\Http\Request;

class PracticDateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::all();
        return view('practics.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'group_id' => 'required',
            'days' => 'required',
        ]);
        $dateArray = explode(',', $request->days);
        foreach ($dateArray as $date) {
            PracticDate::create([
                'group_id' => $request->group_id,
                'year' => $request->year,
                'month' => date('m', strtotime($date)),
                'day' => date('d', strtotime($date)),
            ]);
        }
        return redirect()->back()->with('success', 'Muvofaqiyatli saqlandi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PracticDate $practicDate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PracticDate $practicDate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PracticDate $practicDate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PracticDate $practicDate)
    {
        //
    }
}
