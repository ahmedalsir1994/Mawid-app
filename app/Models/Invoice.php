<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'business_id',
        'license_id',
        'plan',
        'billing_cycle',
        'amount',
        'currency',
        'status',
        'billing_period_start',
        'billing_period_end',
        'paid_at',
        'paymob_order_id',
        'paymob_transaction_id',
        'business_name',
        'business_email',
        'notes',
    ];

    protected $casts = [
        'paid_at'               => 'datetime',
        'billing_period_start'  => 'date',
        'billing_period_end'    => 'date',
        'amount'                => 'decimal:3',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }

    /** Generate the next invoice number: INV-2026-000001 */
    public static function generateNumber(): string
    {
        $year  = now()->year;
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'INV-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    /** Create an invoice after a successful payment */
    public static function createForLicense(License $license, string $paymobOrderId = null, string $txId = null): self
    {
        $cycle     = $license->billing_cycle ?? 'monthly';
        $periodEnd = $cycle === 'yearly' ? now()->addYear() : now()->addMonth();

        return static::create([
            'invoice_number'        => static::generateNumber(),
            'business_id'           => $license->business_id,
            'license_id'            => $license->id,
            'plan'                  => $license->plan,
            'billing_cycle'         => $cycle,
            'amount'                => $license->price,
            'currency'              => 'OMR',
            'status'                => 'paid',
            'billing_period_start'  => now()->toDateString(),
            'billing_period_end'    => $periodEnd->toDateString(),
            'paid_at'               => now(),
            'paymob_order_id'       => $paymobOrderId,
            'paymob_transaction_id' => $txId,
            'business_name'         => $license->business->name ?? '—',
            'business_email'        => $license->business->email ?? null,
        ]);
    }
}
