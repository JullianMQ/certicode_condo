<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [
            [
                'booking_id'    => 'B-001',
                'user_id'       => 'U-101',
                'amenity_id'    => 'A-001',
                'booking_date'  => '2025-10-01',
                'start_time'    => '14:00',
                'end_time'      => '16:00',
                'status'        => 'Confirmed',
                'total_fee_php' => 3000,
                'purpose'       => 'Birthday Party',
                'created_at'    => Carbon::parse('2025-09-24T10:30:00Z'),
                'updated_at'    => Carbon::now(),
            ],
            [
                'booking_id'    => 'B-002',
                'user_id'       => 'U-102',
                'amenity_id'    => 'A-004',
                'booking_date'  => '2025-10-05',
                'start_time'    => '10:00',
                'end_time'      => '11:00',
                'status'        => 'Pending',
                'total_fee_php' => 500,
                'purpose'       => 'Basketball Practice',
                'created_at'    => Carbon::parse('2025-09-25T15:45:00Z'),
                'updated_at'    => Carbon::now(),
            ],
            [
                'booking_id'    => 'B-003',
                'user_id'       => 'U-103',
                'amenity_id'    => 'A-005',
                'booking_date'  => '2025-09-28',
                'start_time'    => '07:00',
                'end_time'      => '08:00',
                'status'        => 'Confirmed',
                'total_fee_php' => 800,
                'purpose'       => 'Tennis Match',
                'created_at'    => Carbon::parse('2025-09-21T09:15:00Z'),
                'updated_at'    => Carbon::now(),
            ],
            [
                'booking_id'    => 'B-004',
                'user_id'       => 'U-101',
                'amenity_id'    => 'A-006',
                'booking_date'  => '2025-10-12',
                'start_time'    => '16:00',
                'end_time'      => '18:00',
                'status'        => 'Pending',
                'total_fee_php' => 2000,
                'purpose'       => 'Family Gathering',
                'created_at'    => Carbon::parse('2025-09-26T14:20:00Z'),
                'updated_at'    => Carbon::now(),
            ],
            [
                'booking_id'    => 'B-005',
                'user_id'       => 'U-102',
                'amenity_id'    => 'A-001',
                'booking_date'  => '2025-09-30',
                'start_time'    => '19:00',
                'end_time'      => '21:00',
                'status'        => 'Cancelled',
                'total_fee_php' => 0,
                'purpose'       => 'Company Meeting',
                'created_at'    => Carbon::parse('2025-09-23T11:00:00Z'),
                'updated_at'    => Carbon::now(),
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }
    }
}
