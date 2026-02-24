<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeOff extends Model
{
    protected $table = 'time_offs';

    protected $fillable = [
        'business_id', 'start_date', 'end_date', 'note'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}