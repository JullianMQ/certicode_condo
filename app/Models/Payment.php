<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'user_id',
        'unit_id',
        'payment_type',
        'amount_php',
        'due_date',
        'status',
        'paid_at',
        'receipt_number',
    ];

    protected $casts = [
        'amount_php' => 'decimal:2',
        'due_date'   => 'date',
        'paid_at'    => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unit()
    {
        return $this->belongsTo(Condo::class, 'unit_id', 'unit_id');
    }

    // Scope for filtering pending payments
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    // Scope for filtering overdue payments
    public function scopeOverdue($query)
    {
        return $query->where('status', 'Overdue');
    }

    // Check if payment is already settled
    public function isPaid(): bool
    {
        return $this->status === 'Paid';
    }
}
