<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'business_id',
        'paymob_token',
        'card_brand',
        'last_four',
        'expiry_month',
        'expiry_year',
        'cardholder_name',
        'is_default',
    ];

    protected $casts = [
        'is_default'    => 'boolean',
        'paymob_token'  => 'encrypted',   // AES-256-CBC at rest via APP_KEY
    ];

    // Never expose the token in API responses or serialization
    protected $hidden = ['paymob_token'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /** Display label e.g. "Visa •••• 4242" */
    public function getDisplayNameAttribute(): string
    {
        $brand = $this->card_brand ?? 'Card';
        $last  = $this->last_four  ?? '????';
        return "{$brand} •••• {$last}";
    }

    /** e.g. "12/28" — returns null if either part is missing */
    public function getExpiryAttribute(): ?string
    {
        if (!$this->expiry_month || !$this->expiry_year) return null;
        $year = strlen((string)$this->expiry_year) === 4
            ? substr($this->expiry_year, -2)
            : $this->expiry_year;
        return $this->expiry_month . '/' . $year;
    }

    // ── Static sanitizers used before saving ─────────────────────────────

    public static function sanitizeBrand(?string $v): ?string
    {
        if (!$v) return null;
        return substr(preg_replace('/[^a-zA-Z0-9\s\-]/u', '', strip_tags($v)), 0, 30);
    }

    public static function sanitizeLastFour(?string $v): ?string
    {
        if (!$v) return null;
        $digits = preg_replace('/\D/', '', (string) $v);
        return strlen($digits) >= 4 ? substr($digits, -4) : null;
    }

    public static function sanitizeName(?string $v): ?string
    {
        if (!$v) return null;
        return substr(preg_replace('/[<>"\'\/\\\\]/u', '', strip_tags(trim($v))), 0, 100);
    }
}
