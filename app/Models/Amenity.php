<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $primaryKey = 'amenity_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'amenity_id',
        'name',
        'building_name',
        'capacity',
        'is_bookable',
        'fee_per_hour_php',
        'operating_hours',
        'advance_booking_days',
    ];

    protected $casts = [
        'is_bookable' => 'boolean',
        'capacity' => 'integer',
        'fee_per_hour_php' => 'integer',
        'advance_booking_days' => 'integer',
    ];

    // An amenity can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'amenity_id', 'amenity_id');
    }
}
