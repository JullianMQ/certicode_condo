<?php

use App\Http\Controllers\GeminiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondoController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AmenityController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PaymentController;


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

// Condos
Route::apiResource('condos', CondoController::class)->names([
    'index' => 'api.condos.index',
    'store' => 'api.condos.store',
    'show' => 'api.condos.show',
    'update' => 'api.condos.update',
    'destroy' => 'api.condos.destroy',
]);

// Bookings
Route::apiResource('bookings', BookingController::class)->names([
    'index' => 'api.bookings.index',
    'store' => 'api.bookings.store',
    'show' => 'api.bookings.show',
    'update' => 'api.bookings.update',
    'destroy' => 'api.bookings.destroy',
]);

// Amenities
Route::apiResource('amenities', AmenityController::class)->names([
    'index' => 'api.amenities.index',
    'store' => 'api.amenities.store',
    'show' => 'api.amenities.show',
    'update' => 'api.amenities.update',
    'destroy' => 'api.amenities.destroy',
]);

// Maintenances
Route::apiResource('maintenances', MaintenanceController::class)->names([
    'index' => 'api.maintenances.index',
    'store' => 'api.maintenances.store',
    'show' => 'api.maintenances.show',
    'update' => 'api.maintenances.update',
    'destroy' => 'api.maintenances.destroy',
]);

// Payments
Route::apiResource('payments', PaymentController::class)->names([
    'index' => 'api.payments.index',
    'store' => 'api.payments.store',
    'show' => 'api.payments.show',
    'update' => 'api.payments.update',
    'destroy' => 'api.payments.destroy',
]);


Route::post('/ask', action: [GeminiController::class, 'ask']);
