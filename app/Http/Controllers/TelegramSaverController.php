<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Image;
use App\Models\Inspector;
use App\Models\PracticDate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Exception;

class TelegramSaverController extends Controller
{
    // 1️⃣ Foydalanuvchini telefon orqali tekshirish
    public function getUser(Request $request)
    {
        try {
            $user = User::where('phone', '+'.trim($request->phone))->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ dualedu.test saytidan ro'yhatdan o'tmagansiz"
                ]);
            }

            $user->update(['telegram_id' => $request->telegram_id]);

            return response()->json([
                'status' => 'success',
                'message' => '✅ Telegram ID saqlandi!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '❌ Xatolik yuz berdi: ' . $e->getMessage()
            ]);
        }
    }

    // 2️⃣ Rasm + geolokatsiyani saqlash
    public function saveImage(Request $request)
    {
        try {
            $telegram_id = $request->input('telegram_id');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $file_id = $request->input('file_id');

            if (!$telegram_id || !$latitude || !$longitude || !$file_id) {
                \Log::info('error:', "❌ So'rovda yetarli ma'lumot yo‘q!");
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ So'rovda yetarli ma'lumot yo‘q!"
                ]);
            }
            $user = User::where('telegram_id', $telegram_id)->first();
            $group_id = optional($user->groups->first())->id;
            $p_day = PracticDate::where('group_id', $group_id)->where('day', date('Y-m-d'))->exists();
            if (!$p_day) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bugun amaliyot kuni emas'
                ]);
            }

            $today = Inspector::where('user_id', $user->id)->whereDate('created_at', '=', date('Y-m-d'))->first();
            if ($today) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bir kunda 1 marta rasm qoldirish mumkun!'
                ]);
            }
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ Foydalanuvchi topilmadi!"
                ]);
            }
            $p_day = PracticDate::where('group_id', $group_id)->where('day', date('Y-m-d'))->exists();

            if (!$p_day) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bugun amaliyot kuni emas'
                ]);
            }


            if (!$user->address) {
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ Foydalanuvchining manzili yo‘q!"
                ]);
            }

            $distance = $this->calculateDistance(
                $user->address->latitude,
                $user->address->longitude,
                $latitude,
                $longitude
            );

            $status = $distance <= 1300;

            // 🛠️ Telegram API orqali rasmni olish
            $telegram_token = env('TELEGRAM_BOT_TOKEN'); // .env ichidan token
            $file_path_url = "https://api.telegram.org/bot{$telegram_token}/getFile?file_id={$file_id}";

            $response = Http::get($file_path_url);
            if ($response->failed()) {
                \Log::info('error: ', $response->json());
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ Telegram'dan fayl ma'lumotini olishda xatolik!"
                ]);
            }

            $file_path = $response->json()['result']['file_path'];
            $photo_url = "https://api.telegram.org/file/bot{$telegram_token}/{$file_path}";

            // 🛠️ Rasmni yuklab olish
            $file_content = Http::get($photo_url);
            if ($file_content->failed()) {
                \Log::info('error: ', $file_content->json());
                return response()->json([
                    'status' => 'error',
                    'message' => "❌ Telegram rasmni yuklab olishda xatolik!"
                ]);
            }

            // 🖼️ Faylni saqlash
            $file_name = time() . ".jpg";
            $storage_path = public_path("uploads/{$file_name}");

            if (!file_exists(dirname($storage_path))) {
                mkdir(dirname($storage_path), 0777, true);
            }

            file_put_contents($storage_path, $file_content);

            $file_url = "uploads/".$file_name;

            $inspector = Inspector::create([
                'user_id' => $user->id,
                'group_id' => $group_id,
                'status' => $status,
                'distance' => $distance,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'withadd' => 'telegram'
            ]);

            Image::create([
                'name' => $file_name,
                'url' => $file_url,
                'inspector_id' => $inspector->id,
            ]);

            return response()->json([
                'status' => $status ? 'success' : 'warning',
                'message' => $status
                    ? '✅ Rasm saqlandi. Siz amaliyot joyidasiz!'
                    : '⚠️ Rasm saqlandi, lekin geolokatsiya mos kelmadi.'
            ]);

        } catch (\Exception $e) {
            \Log::info('error: ', $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => "❌ Xatolik yuz berdi: " . $e->getMessage()
            ]);
        }
    }

    // 3️⃣ Masofa hisoblash funksiyasi
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $radius = 6371000;
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
