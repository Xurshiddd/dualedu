<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\PracticDateController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TelegramAuthController;
use App\Models\Address;
use App\Models\Group;
use App\Models\PracticDate;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->hasRole('Admin')||auth()->user()->hasRole('Moderator')||auth()->user()->hasRole('Inspector')) {
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
        'practics' => PracticDateController::class,
        'students' => StudentController::class,
    ]);
    Route::get('/groups/{group}/users', function($id) {
        $group = Group::with(['users' => function ($query) {
            $query->doesntHave('address');
        }])->findOrFail($id);
        return response()->json($group->users);
    });
    Route::get('/get-practice-dates/{group_id}', function ($group_id) {
        $dates = PracticDate::where('group_id', $group_id)->pluck('day');
        return response()->json($dates);
    });

});
Route::middleware(['guest'])->group(function () {
    Route::get('/auth/telegram/redirect', function () {
        return Socialite::driver('telegram')->redirect();
    });
    Route::get('/auth/telegram/callback', [TelegramAuthController::class, 'callback']);
});

require __DIR__ . '/auth.php';
