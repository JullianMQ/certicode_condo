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

    // GET /condos/{id}
    public function show($id)
    {
        $condo = Condo::find($id);

        if (!$condo) {
            return response()->json(['error' => 'Condo not found'], 404);
        }

        return response()->json($condo);
    }

    // POST /condos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'condo_id' => 'required|string',
            'building_name' => 'required|string',
            'address' => 'required|string',
            'developer' => 'required|string',
            'unit_id' => 'required|string',
            'unit_type' => 'required|string',
            'floor_area_sqm' => 'required|numeric',
            'current_status' => 'required|string',
            'owner_id' => 'nullable|string',
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
    }
    // PUT or PATCH /condos/{id}
    public function update(Request $request, $id)
    {
        $condo = Condo::find($id);

        if (!$condo) {
            return response()->json(['error' => 'Condo not found'], 404);
        }

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

    // DELETE /condos/{id}
    public function destroy($id)
    {
        $condo = Condo::find($id);

        if (!$condo) {
            return response()->json(['error' => 'Condo not found'], 404);
        }

        $condo->delete();

        return response()->json(['message' => 'Condo deleted']);
    }

}
