<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'business_id', 'service_category_id', 'name', 'image', 'description', 'duration_minutes', 'price', 'is_active'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class)->orderBy('sort_order');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_service');
    }

    /**
     * Returns the first uploaded image path, falling back to the legacy `image` field.
     */
    public function getPrimaryImageAttribute(): ?string
    {
        $first = $this->images->first();
        return $first ? $first->path : $this->image;
    }
}