<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'business_id', 'name', 'image', 'description', 'duration_minutes', 'price', 'is_active'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function bookings()
{
    return $this->hasMany(Booking::class);
}

}