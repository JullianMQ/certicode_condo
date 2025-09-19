<?php

use App\Http\Controllers\GeminiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AmenityController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json([
        'message' => 'Hello',
        'data' => [
            'name' => 'John',
            'age' => 25,
        ],
    ]);
});

//condos
Route::apiResource('condos', CondoController::class);

//bookings
Route::apiResource('bookings', BookingController::class);

//amenities
Route::apiResource('amenities', AmenityController::class);


Route::post('/ask', [GeminiController::class, 'ask']);
