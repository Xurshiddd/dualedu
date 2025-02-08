<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Inspector;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    public function index()
    {
        $inspectors = Inspector::with('group','user', 'images')->get();
        return view('inspectors.index', compact('inspectors'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:17408', // 17MB
        ]);
        $directory = 'uploads';
        $userLat = $request->input('latitude');
        $userLon = $request->input('longitude');
        $user = auth()->user();
        if (!$user || !$user->address || is_null($user->address->longitude) || is_null($user->address->latitude)) {
            return redirect()->back()->with('error', 'location yoqilmagan');
        }

        $storedLat = $user->address->latitude;
        $storedLon = $user->address->longitude;
        $distance = $this->calculateDistance($userLat, $userLon, $storedLat, $storedLon);
        $status = $distance <= 1300;
        $file = $request->file('photo');
        $file_name = time().$file->getClientOriginalName();
        $file->move(public_path('uploads'), $file_name);

        $file_url = 'uploads/' . $file_name;

        $inp = Inspector::create([
            'user_id' => $user->id,
            'group_id' => $user->groups[0]->id,
            'status' => $status,
            'distance' => $distance,
        ]);
        Image::create([
            'name' => $file->getClientOriginalName(),
            'url' => $file_url,
            'inspector_id' => $inp->id,
        ]);
        $res = 'Rasm saqlandi geolacatsiya to\'g\'ri kelmadi';
        if ($status == true) {
            $res = 'Rasm saqlandi siz amaliyot joyidasiz';
        }
        return redirect()->back()->with('success', $res);
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $radius = 6371000; // Yer radiusi (metrda)

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $radius * $c;
    }
}
