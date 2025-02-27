<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Image;
use App\Models\Inspector;
use App\Models\PracticDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectorController extends Controller
{
    public function index(Request $request)
    {
        $groupId = $request->get('group_id');
        $date = $request->get('date', date('Y-m-d')); // Default: bugungi sana

        $inspectors = Inspector::with(['user', 'images', 'group'])
            ->when($groupId, function ($query) use ($groupId) {
                $query->where('group_id', $groupId);
            })->whereDate('created_at', '=', $date)->get();

        $groups = Group::all();
        $practiceDates = $groupId ? PracticDate::where('group_id', $groupId)->pluck('day') : [];

        return view('inspectors.index', compact('inspectors', 'groups', 'groupId', 'practiceDates', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:17408', // 17MB
        ]);
        $userLat = $request->input('latitude');
        $userLon = $request->input('longitude');
        $user = auth()->user();
        if (!$user || !$user->address || is_null($user->address->longitude) || is_null($user->address->latitude)) {
            return redirect()->back()->with('error', 'location yoqilmagan');
        }
        $today = Inspector::where('user_id', $user->id)->whereDate('created_at', '=', date('Y-m-d'))->first();
        if ($today) {
            return redirect()->back()->with('error', 'Bir kunda 1 marta rasm qoldirish mumkun!');
        }

        $group_id = optional($user->groups->first())->id;
        $p_day = PracticDate::where('group_id', $group_id)->where('day', date('Y-m-d'))->exists();

        if (!$p_day) {
            return redirect()->back()->with('error', 'Bugun amaliyot kuni emas');
        }
        try {
            DB::beginTransaction();
            $storedLat = $user->address->latitude;
            $storedLon = $user->address->longitude;
            $distance = $this->calculateDistance($userLat, $userLon, $storedLat, $storedLon);
            $status = $distance <= 1300;
            $file = $request->file('photo');
            $file_name = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $file_name);

            $file_url = 'uploads/' . $file_name;

            $inp = Inspector::create([
                'user_id' => $user->id,
                'group_id' => $user->groups[0]->id,
                'status' => $status,
                'distance' => $distance,
                'longitude' => $userLon,
                'latitude' => $userLat,
                'withadd' => 'web'
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
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            $res = $exception->getMessage();
            \Log::error($res);
            return redirect()->back()->with('error', $res);
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
