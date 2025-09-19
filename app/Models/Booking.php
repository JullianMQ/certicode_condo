<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $primaryKey = 'booking_id';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'booking_id',
        'user_id',
        'amenity_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'total_fee_php',
        'purpose',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'total_fee_php' => 'integer',
    ];

    // Each booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Each booking belongs to an amenity
    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id', 'amenity_id');
    }
}
