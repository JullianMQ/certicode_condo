<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Condo;

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

Route::get('/condos', function () {
    return response()->json(Condo::all());
});

Route::get('/condos/{id}', function ($id) {
    return response()->json(Condo::find($id));
});

Route::post('/condos', function (Request $request) {
    $validated = $request->validate([
        'condo_id'        => 'required|string',
        'building_name'   => 'required|string',
        'address'         => 'required|string',
        'developer'       => 'required|string',
        'unit_id'         => 'required|string',
        'unit_type'       => 'required|string',
        'floor_area_sqm'  => 'required|numeric',
        'current_status'  => 'required|string',
        'owner_id'        => 'nullable|string',
        'listing_details' => 'required|array',
    ]);

    if (
        Condo::where('condo_id', $validated['condo_id'])->exists() ||
        Condo::where('unit_id', $validated['unit_id'])->exists()
    ) {
        return response()->json([
            'error' => 'Data already exists'
        ], 409);
    }

    $condo = Condo::create($validated);

    return response()->json($condo, 201);
});

