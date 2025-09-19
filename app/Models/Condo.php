<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condo extends Model
{
    protected $fillable = [
        'condo_id',
        'building_name',
        'address',
        'developer',
        'unit_id',
        'unit_type',
        'floor_area_sqm',
        'current_status',
        'owner_id',
        'listing_details',
    ];

    protected $casts = [
        'listing_details' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class, 'building_name', 'building_name');
    }

}
