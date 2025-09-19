<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    // GET /api/amenities
    public function index()
    {
        // Fetch all amenities with bookings
        return Amenity::with('bookings')->get();
    }

    // GET /api/amenities/{id}
    public function show($id)
    {
        $amenity = Amenity::with('bookings')->findOrFail($id);
        return response()->json($amenity);
    }

    // POST /api/amenities
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amenity_id' => 'required|string|unique:amenities,amenity_id',
            'name' => 'required|string|max:255',
            'building_name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'is_bookable' => 'boolean',
            'fee_per_hour_php' => 'nullable|integer',
            'operating_hours' => 'nullable|string',
            'advance_booking_days' => 'nullable|integer',
        ]);

        $amenity = Amenity::create($validated);

        return response()->json($amenity, 201);
    }

    // PUT/PATCH /api/amenities/{id}
    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'building_name' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer',
            'is_bookable' => 'boolean',
            'fee_per_hour_php' => 'nullable|integer',
            'operating_hours' => 'nullable|string',
            'advance_booking_days' => 'nullable|integer',
        ]);

        $amenity->update($validated);

        return response()->json($amenity);
    }

    // DELETE /api/amenities/{id}
    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        return response()->json(null, 204);
    }
}
