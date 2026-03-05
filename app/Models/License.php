<?php

namespace App\Models;

use App\Services\PlanService;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'license_key',
        'plan',
        'billing_cycle',
        'status',
        'max_users',
        'max_daily_bookings',
        'max_branches',
        'max_staff',
        'max_services',
        'whatsapp_reminders',
        'activated_at',
        'expires_at',
        'price',
        'payment_status',
        'notes',
        'paymob_order_id',
        'auto_renew',
        'next_billing_date',
        'past_due_at',
        'auto_renew_attempts',
        'grace_period_ends_at',
    ];

    protected $casts = [
        'activated_at'         => 'date',
        'expires_at'           => 'date',
        'next_billing_date'    => 'date',
        'past_due_at'          => 'datetime',
        'grace_period_ends_at' => 'date',
        'whatsapp_reminders'   => 'boolean',
        'auto_renew'           => 'boolean',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function latestInvoice()
    {
        return $this->hasOne(Invoice::class)->latestOfMany();
    }

    /** Can the business add another branch? */
    public function canAddBranch(): bool
    {
        $limit = $this->max_branches ?? 1;
        $count = $this->business->branches()->count();
        return $count < $limit;
    }

    public function branchesUsed(): int
    {
        return $this->business->branches()->count();
    }

    public function isActive(): bool
    {
        // Free plan never expires — it is always active.
        if ($this->isFree()) {
            return true;
        }
        // Past-due accounts still work during the grace period.
        if ($this->status === 'past_due' && $this->isInGracePeriod()) {
            return true;
        }
        return $this->status === 'active' && (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function isExpiring(): bool
    {
        // Free plan has no expiry concept.
        if ($this->isFree()) {
            return false;
        }
        $daysLeft = $this->expires_at->isFuture()
            ? (int) abs($this->expires_at->diffInDays(now()))
            : -1;
        return $this->expires_at && $this->expires_at->isFuture() && $daysLeft <= 7;
    }

    public function daysUntilExpiry(): ?int
    {
        return $this->expires_at ? abs($this->expires_at->diffInDays(now(), false)) : null;
    }

    // ───────────────────────────────────────────────
    // Plan helpers
    // ───────────────────────────────────────────────

    public function isFree(): bool   { return ($this->plan ?? 'free') === 'free'; }
    public function isPro(): bool    { return $this->plan === 'pro'; }
    public function isPlus(): bool   { return $this->plan === 'plus'; }

    public function isPastDue(): bool
    {
        return $this->status === 'past_due';
    }

    public function isInGracePeriod(): bool
    {
        // Use date-string comparison so the full end day is included.
        // isFuture() would fail on the end date itself (midnight cast from DATE column).
        return $this->status === 'past_due'
            && $this->grace_period_ends_at
            && $this->grace_period_ends_at->toDateString() >= now()->toDateString();
    }

    public function graceDaysRemaining(): int
    {
        if (!$this->isInGracePeriod()) return 0;
        return max(0, (int) now()->diffInDays($this->grace_period_ends_at, false));
    }

    /**
     * Mark this license as past_due with a 5-day grace period.
     * Called by auto-renewal job when a charge fails.
     */
    public function markPastDue(string $reason = 'Payment failed.'): void
    {
        $this->update([
            'status'               => 'past_due',
            'payment_status'       => 'failed',
            'past_due_at'          => now(),
            'grace_period_ends_at' => now()->addDays(5)->toDateString(),
        ]);

        // Notify the business admin
        $admin = $this->business?->users()
            ->where('role', 'company_admin')
            ->first();

        if ($admin) {
            \Illuminate\Support\Facades\Mail::to($admin->email)
                ->send(new \App\Mail\PaymentFailedMail($admin, $this, $reason));
        }
    }

    public function planData(): array
    {
        return PlanService::get($this->plan ?? 'free');
    }

    /** Can the business add another service? */
    public function canAddService(): bool
    {
        $limit = $this->max_services ?? 3;
        $count = $this->business->services()->count();
        return $count < $limit;
    }

    /** Can the business add another staff member? */
    public function canAddStaff(): bool
    {
        $limit = $this->max_staff ?? 1;
        $count = $this->business->users()->where('role', 'staff')->count();
        return $count < $limit;
    }

    public function servicesUsed(): int
    {
        return $this->business->services()->count();
    }

    public function staffUsed(): int
    {
        return $this->business->users()->where('role', 'staff')->count();
    }

    // ───────────────────────────────────────────────
    // Monthly booking limit (free plan = 25/month)
    // ───────────────────────────────────────────────

    /** 0 means unlimited */
    public function maxMonthlyBookings(): int
    {
        return (int) ($this->planData()['max_monthly_bookings'] ?? 0);
    }

    public function monthlyBookingsUsed(): int
    {
        return $this->business->bookings()
            ->whereYear('booking_date', now()->year)
            ->whereMonth('booking_date', now()->month)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();
    }

    public function canAcceptBookingThisMonth(): bool
    {
        $max = $this->maxMonthlyBookings();
        if ($max === 0) return true; // unlimited
        return $this->monthlyBookingsUsed() < $max;
    }

    /** Apply a new paid plan to this license (called after payment confirmation) */
    public function applyPlan(string $plan, string $cycle, ?string $paymobOrderId = null, ?string $txId = null): void
    {
        $planData  = PlanService::get($plan);
        $expiresAt = $plan === 'free' ? null : ($cycle === 'yearly' ? now()->addYear() : now()->addMonth());
        $price     = PlanService::price($plan, $cycle);

        $this->update([
            'plan'               => $plan,
            'billing_cycle'      => $cycle,
            'status'             => 'active',
            'payment_status'     => 'paid',
            'max_users'          => $planData['max_staff'] + 1,
            'max_daily_bookings' => $planData['max_daily_bookings'],
            'max_branches'       => $planData['max_branches'],
            'max_staff'          => $planData['max_staff'],
            'max_services'       => $planData['max_services'],
            'whatsapp_reminders' => $planData['whatsapp_reminders'],
            'expires_at'         => $expiresAt,
            'next_billing_date'  => $expiresAt?->toDateString(),
            'price'              => $price,
            'paymob_order_id'    => $paymobOrderId ?? $this->paymob_order_id,
            'activated_at'       => $this->activated_at ?? now()->toDateString(),
            'auto_renew'         => $this->auto_renew ?? true,
            'auto_renew_attempts' => 0,
            'past_due_at'        => null,
            'grace_period_ends_at' => null,   // clear grace period on successful payment
        ]);

        // Generate invoice
        if ($plan !== 'free') {
            Invoice::createForLicense($this->fresh(), $paymobOrderId, $txId);
        }
    }
}
