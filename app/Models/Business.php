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
        'gallery_images',
        'country',
        'timezone',
        'currency',
        'mobile',
        'business_type',
        'company_size',
        'address',
        'default_language',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'gallery_images' => 'array',
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

    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategory::class);
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

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function mainBranch()
    {
        return $this->hasOne(Branch::class)->where('is_main', true)->latestOfMany('id');
    }

    public function admin()
    {
        return $this->users()->where('role', 'company_admin')->first();
    }

    public function staff()
    {
        return $this->users()->where('role', 'staff');
    }

    public function invoices()
    {
        return $this->hasMany(\App\Models\Invoice::class)->latest();
    }

    public function paymentMethods()
    {
        return $this->hasMany(\App\Models\PaymentMethod::class);
    }

    public function defaultPaymentMethod(): ?\App\Models\PaymentMethod
    {
        return $this->paymentMethods()->where('is_default', true)->first();
    }
}