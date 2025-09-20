<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    // List all maintenance requests
    public function index()
    {
        $maintenances = Maintenance::with(['user', 'assignedTo', 'unit'])->get();
        return response()->json($maintenances);
    }

    // Show a specific maintenance request
    public function show($id)
    {
        $maintenance = Maintenance::with(['user', 'assignedTo', 'unit'])->find($id);

        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance request not found'], 404);
        }

        return response()->json($maintenance);
    }

    // Create a new maintenance request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_id' => 'required|unique:maintenances,request_id',
            'unit_id' => 'required|string',
            'user_id' => 'required|string',
            'category' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'nullable|in:Submitted,Assigned,In Progress,Resolved',
            'urgency' => 'nullable|in:Low,Medium,High',
            'assigned_to_user_id' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'resolved_at' => 'nullable|date',
        ]);

        $maintenance = Maintenance::create($validated);

        return response()->json($maintenance, 201);
    }

    // Update a maintenance request
    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance request not found'], 404);
        }

        $validated = $request->validate([
            'unit_id' => 'sometimes|string',
            'user_id' => 'sometimes|string',
            'category' => 'sometimes|string',
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:Submitted,Assigned,In Progress,Resolved',
            'urgency' => 'sometimes|in:Low,Medium,High',
            'assigned_to_user_id' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'resolved_at' => 'nullable|date',
        ]);

        $maintenance->update($validated);

        return response()->json($maintenance);
    }

    // Delete a maintenance request
    public function destroy($id)
    {
        $maintenance = Maintenance::find($id);

        if (!$maintenance) {
            return response()->json(['message' => 'Maintenance request not found'], 404);
        }

        $maintenance->delete();

        return response()->json(['message' => 'Maintenance request deleted successfully']);
    }
}
