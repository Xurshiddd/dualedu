<?php

use App\Http\Controllers\TelegramSaverController;
use Illuminate\Support\Facades\Route;

Route::post('/getuser', [TelegramSaverController::class, 'getUser']);
Route::post('/savedata', [TelegramSaverController::class, 'saveImage']);
