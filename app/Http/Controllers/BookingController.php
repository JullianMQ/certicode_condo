<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Get all bookings
    public function index()
    {
        $bookings = Booking::with(['user', 'amenity'])->get();
        return response()->json($bookings);
    }

    // Show single booking
    public function show($id)
    {
        $booking = Booking::with(['user', 'amenity'])->findOrFail($id);
        return response()->json($booking);
    }

    // Store new booking
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id'     => 'required|string|unique:bookings,booking_id',
            'user_id'        => 'required|string|exists:users,id',
            'amenity_id'     => 'required|string|exists:amenities,amenity_id',
            'booking_date'   => 'required|date',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
            'status'         => 'required|string',
            'total_fee_php'  => 'required|integer|min:0',
            'purpose'        => 'nullable|string',
        ]);

        $booking = Booking::create($validated);

        return response()->json($booking, 201);
    }

    // Update booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'user_id'        => 'sometimes|string|exists:users,id',
            'amenity_id'     => 'sometimes|string|exists:amenities,amenity_id',
            'booking_date'   => 'sometimes|date',
            'start_time'     => 'sometimes|date_format:H:i',
            'end_time'       => 'sometimes|date_format:H:i|after:start_time',
            'status'         => 'sometimes|string',
            'total_fee_php'  => 'sometimes|integer|min:0',
            'purpose'        => 'nullable|string',
        ]);

        $booking->update($validated);

        return response()->json($booking);
    }

    // Delete booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
