<?php

namespace App\Http\Controllers;

use App\Models\Condo;
use Illuminate\Http\Request;

class CondoController extends Controller
{
    // GET /condos
    public function index()
    {
        return response()->json(Condo::all());
    }

    // GET /condos/{condo}
    public function show(Condo $condo)
    {
        return response()->json($condo);
    }

    // POST /condos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'condo_id' => 'required|string|unique:condos,condo_id',
            'building_name' => 'required|string',
            'address' => 'required|string',
            'developer' => 'required|string',
            'unit_id' => 'required|string|unique:condos,unit_id',
            'unit_type' => 'required|string',
            'floor_area_sqm' => 'required|numeric',
            'current_status' => 'required|string',
            'owner_id' => 'nullable|string',
            'listing_details' => 'required|array',
        ]);

        $condo = Condo::create($validated);

        return response()->json($condo, 201);
    }

    // PUT or PATCH /condos/{condo}
    public function update(Request $request, Condo $condo)
    {
        $validated = $request->validate([
            'building_name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'developer' => 'sometimes|string',
            'unit_type' => 'sometimes|string',
            'floor_area_sqm' => 'sometimes|numeric',
            'current_status' => 'sometimes|string',
            'owner_id' => 'nullable|string',
            'listing_details' => 'sometimes|array',
        ]);

        $condo->update($validated);

        return response()->json($condo);
    }

    // DELETE /condos/{condo}
    public function destroy(Condo $condo)
    {
        $condo->delete();

        return response()->json(['message' => 'Condo deleted']);
    }
}
