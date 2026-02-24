<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'license_key',
        'status',
        'max_users',
        'max_daily_bookings',
        'activated_at',
        'expires_at',
        'price',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'activated_at' => 'date',
        'expires_at' => 'date',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function isExpiring(): bool
    {
        return $this->expires_at && $this->expires_at->diffInDays(now()) <= 7 && $this->expires_at->isFuture();
    }

    public function daysUntilExpiry(): ?int
    {
        return $this->expires_at ? abs($this->expires_at->diffInDays(now(), false)) : null;
    }
}
