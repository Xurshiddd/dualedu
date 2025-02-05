<?php

namespace App\Http\Controllers;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class TelegramAuthController extends Controller
{
    public function callback()
    {
        $telegramUser = Socialite::driver('telegram')->user();
        $user = User::where('telegram_id', (int)$telegramUser->getId())->first();
        if (!$user) {
            return redirect()->route('login');
        }

        auth()->login($user);

        return redirect()->route('dashboard')->with('success', 'Logged in via Telegram!');
    }
}
