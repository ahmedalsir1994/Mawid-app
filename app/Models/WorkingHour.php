<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = [
        'business_id', 'day_of_week',
        'first_shift_start', 'first_shift_end',
        'second_shift_start', 'second_shift_end',
        'is_closed'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}