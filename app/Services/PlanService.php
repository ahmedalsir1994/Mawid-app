<?php

namespace App\Services;

use App\Models\Plan;

class PlanService
{
    /**
     * Fallback static definitions used when the plans table is unavailable
     * (e.g. during the very first migration run before seeding).
     */
    const PLANS = [
        'free' => [
            'name'                  => 'Free',
            'emoji'                 => '🆓',
            'tagline'               => 'For small solo shops testing the system',
            'price_monthly'         => 0,
            'price_yearly'          => 0,
            'max_branches'          => 1,
            'max_staff'             => 1,
            'max_services'          => 3,
            'max_daily_bookings'    => 25,
            'max_monthly_bookings'  => 25,
            'whatsapp_reminders'    => true,
            'core_features' => [
                'Booking calendar',
                'Customer records',
                'Basic appointments',
                'Manual confirmations',
            ],
            'limits' => [
                '1 Branch',
                '1 Staff account',
                'Up to 3 services',
                'WhatsApp reminders',
            ],
        ],
        'pro' => [
            'name'                  => 'Pro',
            'emoji'                 => '💼',
            'tagline'               => 'For a real working shop',
            'price_monthly'         => 6.5,
            'price_yearly'          => 66.00,   // 5.5 OMR × 12
            'price_monthly_display' => 6.5,     // shown on pricing card
            'price_yearly_display'  => 5.5,     // per-month equivalent shown yearly
            'old_price_monthly'     => 10,
            'old_price_yearly'      => 120,
            'discount_monthly'      => 35,      // %
            'discount_yearly'       => 45,      // %
            'max_branches'          => 1,
            'max_staff'             => 3,
            'max_services'          => 15,
            'max_daily_bookings'    => 200,
            'max_monthly_bookings'  => 0,
            'whatsapp_reminders'    => true,
            'core_features' => [
                'Everything in Free',
                'Up to 15 Services',
                'Up to 3 Staff Accounts',
                'Automated WhatsApp Reminders',
            ],
            'limits' => [
                '1 Branch',
                'Up to 3 Staff Accounts',
                'Up to 15 Services',
                'WhatsApp Reminders',
            ],
        ],
        'plus' => [
            'name'                  => 'Plus',
            'emoji'                 => '🚀',
            'tagline'               => 'For growing businesses & multi-chair shops',
            'price_monthly'         => 9.8,
            'price_yearly'          => 109.20,  // 9.1 OMR × 12
            'price_monthly_display' => 9.8,
            'price_yearly_display'  => 9.1,     // per-month equivalent
            'old_price_monthly'     => 14,
            'old_price_yearly'      => 168,
            'discount_monthly'      => 30,      // %
            'discount_yearly'       => 35,      // %
            'max_branches'          => 3,
            'max_staff'             => 15,
            'max_services'          => 999,
            'max_daily_bookings'    => 999,
            'max_monthly_bookings'  => 0,
            'whatsapp_reminders'    => true,
            'core_features' => [
                'Everything in Pro',
                '3 Branch Locations',
                '5 Staff Per Branch',
                'Unlimited Services',
                'Priority Support',
            ],
            'limits' => [
                '3 Branch Locations',
                '5 Staff Per Branch',
                'Unlimited Services',
                'Priority Support',
            ],
        ],
    ];

    /**
     * Get a single plan's data array by slug.
     * Reads from the DB plans table; falls back to the static PLANS constant
     * if the table does not exist yet (e.g. during initial migration).
     */
    public static function get(string $plan): array
    {
        try {
            $model = Plan::where('slug', $plan)->first();
            if ($model) {
                return $model->toServiceArray();
            }
        } catch (\Exception) {
            // DB unavailable — fall through to static fallback
        }

        return self::PLANS[$plan] ?? self::PLANS['free'];
    }

    /**
     * Return all active plans as an array keyed by slug.
     */
    public static function all(): array
    {
        try {
            $collection = Plan::active()->orderBy('sort_order')->get();
            if ($collection->isNotEmpty()) {
                return $collection->keyBy('slug')->map(fn($p) => $p->toServiceArray())->toArray();
            }
        } catch (\Exception) {
            // DB unavailable — fall through
        }

        return self::PLANS;
    }

    public static function price(string $plan, string $cycle = 'monthly'): float
    {
        $planData = self::get($plan);
        return $cycle === 'yearly' ? $planData['price_yearly'] : $planData['price_monthly'];
    }

    public static function discountPercent(string $plan = 'pro', string $cycle = 'monthly'): int
    {
        $data = self::get($plan);
        if ($cycle === 'yearly') return $data['discount_yearly'] ?? 0;
        return $data['discount_monthly'] ?? 0;
    }

    public static function oldPrice(string $plan, string $cycle = 'monthly'): float
    {
        $data = self::get($plan);
        return $cycle === 'yearly' ? ($data['old_price_yearly'] ?? 0) : ($data['old_price_monthly'] ?? 0);
    }

    /**
     * Calculate the amount in the smallest currency unit (fils for OMR, 1 OMR = 1000 fils)
     */
    public static function amountInFils(string $plan, string $cycle = 'monthly'): int
    {
        return (int) (self::price($plan, $cycle) * 1000);
    }
}
