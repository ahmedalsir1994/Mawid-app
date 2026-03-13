<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'emoji',
        'tagline',
        'price_monthly',
        'price_yearly',
        'price_monthly_display',
        'price_yearly_display',
        'old_price_monthly',
        'old_price_yearly',
        'discount_monthly',
        'discount_yearly',
        'max_branches',
        'max_staff',
        'max_services',
        'max_daily_bookings',
        'max_monthly_bookings',
        'whatsapp_reminders',
        'features',
        'is_featured',
        'featured_label',
        'cta_label',
        'accent_color',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_monthly'         => 'float',
        'price_yearly'          => 'float',
        'price_monthly_display' => 'float',
        'price_yearly_display'  => 'float',
        'old_price_monthly'     => 'float',
        'old_price_yearly'      => 'float',
        'discount_monthly'      => 'integer',
        'discount_yearly'       => 'integer',
        'max_branches'          => 'integer',
        'max_staff'             => 'integer',
        'max_services'          => 'integer',
        'max_daily_bookings'    => 'integer',
        'max_monthly_bookings'  => 'integer',
        'whatsapp_reminders'    => 'boolean',
        'features'              => 'array',
        'is_featured'           => 'boolean',
        'is_active'             => 'boolean',
        'sort_order'            => 'integer',
    ];

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePaid($query)
    {
        return $query->where('price_monthly', '>', 0)->orWhere('price_yearly', '>', 0);
    }

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function licenses()
    {
        return $this->hasMany(License::class, 'plan', 'slug');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────────

    public static function findBySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->first();
    }

    public function isFree(): bool
    {
        return $this->price_monthly == 0 && $this->price_yearly == 0;
    }

    public function price(string $cycle = 'monthly'): float
    {
        return $cycle === 'yearly' ? $this->price_yearly : $this->price_monthly;
    }

    public function amountInFils(string $cycle = 'monthly'): int
    {
        return (int) ($this->price($cycle) * 1000);
    }

    /**
     * Convert to the same array shape PlanService used to return,
     * so all legacy code that expects an array continues to work.
     */
    public function toServiceArray(): array
    {
        return [
            'slug'                  => $this->slug,
            'name'                  => $this->name,
            'emoji'                 => $this->emoji,
            'tagline'               => $this->tagline ?? '',
            'price_monthly'         => $this->price_monthly,
            'price_yearly'          => $this->price_yearly,
            'price_monthly_display' => $this->price_monthly_display ?? $this->price_monthly,
            'price_yearly_display'  => $this->price_yearly_display  ?? ($this->price_yearly / 12),
            'old_price_monthly'     => $this->old_price_monthly,
            'old_price_yearly'      => $this->old_price_yearly,
            'discount_monthly'      => $this->discount_monthly,
            'discount_yearly'       => $this->discount_yearly,
            'max_branches'          => $this->max_branches,
            'max_staff'             => $this->max_staff,
            'max_services'          => $this->max_services,
            'max_daily_bookings'    => $this->max_daily_bookings,
            'max_monthly_bookings'  => $this->max_monthly_bookings,
            'whatsapp_reminders'    => $this->whatsapp_reminders,
            'features'              => $this->features ?? [],
            'is_featured'           => $this->is_featured,
            'featured_label'        => $this->featured_label ?? 'Most Popular',
            'cta_label'             => $this->cta_label ?? '',
            'accent_color'          => $this->accent_color ?? 'gray',
        ];
    }
}
