<?php

namespace App\Http\Controllers;

use App\Models\User;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class TelegramAuthController extends Controller
{
    public function callback()
    {
        $telegramUser = Socialite::driver('telegram')->user();
        $user = User::where('telegram_id', (int)$telegramUser->getId())->first();
        if (!$user) {
            $user = User::create([
                'name' => $telegramUser->getName() ?? '',
                'email' => $telegramUser->getEmail() ?? $telegramUser->getName() . '@telegram.com',
                'password' => Hash::make(uniqid()),
                'telegram_id' => $telegramUser->getId(),
            ]);
        }

        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Logged in via Telegram!');
    }
}
