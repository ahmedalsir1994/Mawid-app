<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Branch extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'slug',
        'address',
        'phone',
        'is_active',
        'is_main',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_main'   => 'boolean',
    ];

    // ---------- Boot ----------

    protected static function booted(): void
    {
        static::creating(function (Branch $branch) {
            if (empty($branch->slug)) {
                $branch->slug = Str::slug($branch->name);
            }
        });
    }

    // ---------- Relationships ----------

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'branch_service');
    }

    public function staff()
    {
        return $this->hasMany(User::class)->where('role', 'staff');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
