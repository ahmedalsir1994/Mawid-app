<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Business extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'country',
        'timezone',
        'currency',
        'phone',
        'address',
        'default_language',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }

    public function timeOff()
    {
        return $this->hasMany(TimeOff::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function license()
    {
        return $this->hasOne(License::class);
    }

    public function admin()
    {
        return $this->users()->where('role', 'company_admin')->first();
    }

    public function staff()
    {
        return $this->users()->where('role', 'staff');
    }
}