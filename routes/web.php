<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TelegramAuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    if (auth()->check()) {
        return view('dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');
Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::resources([
        'roles' => RoleController::class,
        'permissions' => PermissionController::class,
        'users' => UserController::class,
    ]);
});
Route::get('/auth/telegram', [TelegramAuthController::class, 'handleTelegramCallback'])->name('auth.telegram');
Route::get('/auth/telegram/redirect', function () {
    dd('asdasd');
//    return Socialite::driver('telegram')->redirect();
});
////Route::get('/auth/telegram/callback', [TelegramAuthController::class, 'callback']);
//Route::get('/auth/telegram/callback', function () {
//    dd('asdas');
//    $user = Socialite::driver('telegram')->user();
//});
require __DIR__ . '/auth.php';
