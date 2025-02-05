<?php

namespace App\Http\Controllers;
use App\Services\ImageService;
use Illuminate\Http\Request;

class InspectorController extends Controller
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
        $userLat = $request->input('latitude');
        $userLon = $request->input('longitude');
        $user = auth()->user();
        $storedLat = $user->address()->lat;
        $storedLon = $user->address()->long;
        $distance = $this->calculateDistance($userLat, $userLon, $storedLat, $storedLon);
        if ($distance <= 500 || ($userLat == $storedLat && $userLon == $storedLon)) {

            // Rasmni saqlash
            $photo_name = Str::random(10);
            $directory = 'uploads/photos/';

            if (in_array(strtolower($image->getClientOriginalExtension()), ['jpg', 'png', 'jpeg', 'gif', 'webp'])) {
                $photoPath = $this->uploadImage($image, $directory); // uploadImage metodi
            }

            // Rasmga saqlangan URLni saqlash
            $user->photo = $photoPath;
            $user->save();

            return response()->json(['message' => 'Image uploaded successfully!', 'photo_url' => $photoPath]);
        } else {
            return response()->json(['message' => 'The location is too far to upload the image.'], 400);
        }
    }
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $radius = 6371000; // Yer radiusi, metrda

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dlat = $lat2 - $lat1;
        $dlon = $lon2 - $lon1;

        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $radius * $c; // masofa metrda

        return $distance;
    }
}
