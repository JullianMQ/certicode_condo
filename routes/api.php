<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondoController;

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


Route::get('/condos', [CondoController::class, 'index']);
Route::get('/condos/{id}', [CondoController::class, 'show']);
Route::post('/condos', [CondoController::class, 'store']);
Route::put('/condos/{id}', [CondoController::class, 'update']);
Route::delete('/condos/{id}', [CondoController::class, 'destroy']);

