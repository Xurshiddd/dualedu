<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/getuser', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'hammasi zo\'r gap yo\'q'
    ]);
});
