<?php

namespace App\Models;
use App\Models\User;
use App\Models\Condo;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = [
        'request_id',
        'unit_id',
        'user_id',
        'category',
        'title',
        'description',
        'status',
        'urgency',
        'assigned_to_user_id',
        'submitted_at',
        'resolved_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    // Example relationships if you have a User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    // Each maintenance request belongs to a unit
    public function unit()
    {
        return $this->belongsTo(Condo::class, 'unit_id', 'unit_id');
    }
}
