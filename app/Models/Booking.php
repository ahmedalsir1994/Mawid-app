<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'business_id', 'service_id', 'staff_user_id',
        'customer_name', 'customer_phone', 'customer_country',
        'booking_date', 'start_time', 'end_time',
        'status', 'reference_code', 'reminder_sent_at'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_user_id');
    }

    protected $casts = [
        'reminder_sent_at' => 'datetime',
    ];

}