<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return response()->json([
        'status' => true,
        'status_code' => 200,
        'message' => 'API is working!'
    ], 200);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');
