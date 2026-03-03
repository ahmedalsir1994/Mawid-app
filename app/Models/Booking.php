<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;

class Booking extends Model
{
    protected $fillable = [
        'business_id', 'branch_id', 'service_id', 'staff_user_id',
        'customer_name', 'customer_phone', 'customer_email', 'customer_country', 'customer_notes',
        'booking_date', 'start_time', 'end_time',
        'status', 'reference_code', 'reminder_sent_at', 'is_walk_in'
    ];

    protected $casts = [
        'reminder_sent_at' => 'datetime',
        'is_walk_in'       => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_user_id');
    }
}