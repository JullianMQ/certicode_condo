<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Load and validate JSON data
            $condos = $this->loadJsonData('condos.json');
            $bookings = $this->loadJsonData('bookings.json');
            $maintenance = $this->loadJsonData('maintenance.json');
            
            // Transform condos data to match view expectations
            $condos = array_map(function($condo) {
                return [
                    'id' => $condo['condo_id'] ?? null,
                    'unit_id' => $condo['unit_id'] ?? null,
                    'building' => $condo['building_name'] ?? 'Unknown',
                    'status' => $condo['current_status'] ?? 'Vacant',
                    'type' => $condo['unit_type'] ?? 'N/A',
                    'area' => $condo['floor_area_sqm'] ?? 0,
                    'owner_id' => $condo['owner_id'] ?? null,
                    'details' => $condo['listing_details'] ?? []
                ];
            }, $condos);

            // Load additional data
            $users = $this->loadJsonData('users.json');
            $amenities = $this->loadJsonData('amenities.json');
            $payments = $this->loadJsonData('payments.json');

            // Transform bookings data to include amenity names
            $amenitiesMap = collect($amenities)->keyBy('amenity_id');
            $bookings = array_map(function($booking) use ($amenitiesMap) {
                $amenity = $amenitiesMap->get($booking['amenity_id'] ?? '');
                return [
                    'id' => $booking['booking_id'] ?? null,
                    'amenity_id' => $booking['amenity_id'] ?? null,
                    'amenity_name' => $amenity['name'] ?? 'Unknown Amenity',
                    'booking_date' => $booking['booking_date'] ?? null,
                    'start_time' => $booking['start_time'] ?? null,
                    'end_time' => $booking['end_time'] ?? null,
                    'status' => $booking['status'] ?? 'Unknown',
                    'purpose' => $booking['purpose'] ?? null,
                    'user_id' => $booking['user_id'] ?? null,
                    'total_fee' => $booking['total_fee_php'] ?? 0
                ];
            }, $bookings);

            // Transform maintenance data
            $maintenance = array_map(function($item) {
                return [
                    'id' => $item['request_id'] ?? null,
                    'title' => $item['title'] ?? 'Maintenance Request',
                    'description' => $item['description'] ?? 'No description provided',
                    'unit_id' => $item['unit_id'] ?? 'N/A',
                    'category' => $item['category'] ?? 'General',
                    'status' => $item['status'] ?? 'Submitted',
                    'urgency' => $item['urgency'] ?? 'Medium',
                    'user_id' => $item['user_id'] ?? null,
                    'assigned_to_user_id' => $item['assigned_to_user_id'] ?? null,
                    'submitted_at' => $item['submitted_at'] ?? null,
                    'resolved_at' => $item['resolved_at'] ?? null
                ];
            }, $maintenance);

            return view('dashboard', compact('condos', 'bookings', 'maintenance', 'users', 'amenities', 'payments'));
            
        } catch (\Exception $e) {
            // Log the error and return a safe default
            \Log::error('Dashboard data loading error: ' . $e->getMessage());
            
            // Return empty arrays to prevent view errors
            return view('dashboard', [
                'condos' => [],
                'bookings' => [],
                'maintenance' => [],
                'users' => [],
                'amenities' => [],
                'payments' => []
            ]);
        }
    }

    /**
     * Load and decode JSON data from file
     */
    private function loadJsonData($filename)
    {
        $path = base_path("data/{$filename}");
        
        if (!File::exists($path)) {
            return [];
        }
        
        $data = json_decode(File::get($path), true);
        
        return is_array($data) ? $data : [];
    }
}
