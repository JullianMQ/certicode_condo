<?php

use App\Http\Controllers\GeminiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\MaintenanceController;



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
Route::apiResource('condos', CondoController::class)->names([
    'index' => 'api.bookings.index',
    'store' => 'api.bookings.store',
    'show' => 'api.bookings.show',
    'update' => 'api.bookings.update',
    'destroy' => 'api.bookings.destroy',
]);

//bookings
Route::apiResource('bookings', BookingController::class)->names([
    'index' => 'api.bookings.index',
    'store' => 'api.bookings.store',
    'show' => 'api.bookings.show',
    'update' => 'api.bookings.update',
    'destroy' => 'api.bookings.destroy',
]);

//amenities
Route::apiResource('amenities', AmenityController::class)->names([
    'index' => 'api.bookings.index',
    'store' => 'api.bookings.store',
    'show' => 'api.bookings.show',
    'update' => 'api.bookings.update',
    'destroy' => 'api.bookings.destroy',
]);

//maintenances
Route::apiResource('maintenances', MaintenanceController::class);

Route::post('/ask', action: [GeminiController::class, 'ask']);
