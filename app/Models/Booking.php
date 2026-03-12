<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
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

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_services');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_user_id');
    }

    /**
     * Returns all services for this booking.
     * For multi-service bookings: returns the booking_services pivot entries.
     * For legacy single-service bookings: returns a collection containing just the primary service.
     */
    public function allServices(): Collection
    {
        if ($this->relationLoaded('services')) {
            // Relation already loaded — use it directly to avoid extra queries
            if ($this->services->isNotEmpty()) {
                return $this->services;
            }
            // Loaded but empty → legacy booking, fall back to primary service
            $single = $this->service ?? $this->service()->first();
            return collect($single ? [$single] : []);
        }

        // Relation not yet loaded — query DB
        $pivot = $this->services()->get();
        if ($pivot->isNotEmpty()) {
            return $pivot;
        }
        // Fall back to primary service (legacy bookings)
        $single = $this->service ?? $this->service()->first();
        return collect($single ? [$single] : []);
    }

    /**
     * Comma-separated service names — safe for both single and multi-service bookings.
     */
    public function getServicesLabelAttribute(): string
    {
        return $this->allServices()->pluck('name')->join(', ');
    }

    /**
     * Total duration across all selected services.
     */
    public function getTotalDurationAttribute(): int
    {
        return (int) $this->allServices()->sum('duration_minutes');
    }
}