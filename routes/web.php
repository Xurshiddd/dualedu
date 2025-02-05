<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\TelegramAuthController;
use App\Models\Group;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('Admin')) {
            return view('dashboard');
        }else {
            return view('welcome');
        }
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
        'addresses' => AddressController::class,
        'groups' => GroupController::class,
        'inspectors' => InspectorController::class,
    ]);
    Route::get('/groups/{group}/users', function($id) {
        $group = Group::with('users')->findOrFail($id);
        return response()->json($group->users);
    });
});
Route::middleware(['guest'])->group(function () {
    Route::get('/auth/telegram/redirect', function () {
        return Socialite::driver('telegram')->redirect();
    });
    Route::get('/auth/telegram/callback', [TelegramAuthController::class, 'callback']);
});
require __DIR__ . '/auth.php';
