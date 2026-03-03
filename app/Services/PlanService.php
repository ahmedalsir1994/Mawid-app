<?php

namespace App\Services;

class PlanService
{
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
            'whatsapp_reminders'    => false,
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
                'No WhatsApp reminders',
            ],
        ],
        'pro' => [
            'name'                  => 'Pro',
            'emoji'                 => '💼',
            'tagline'               => 'For a real working shop',
            'price_monthly'         => 5,
            'price_yearly'          => 57.00,
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
            'price_monthly'         => 9,
            'price_yearly'          => 102.60,
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

    public static function get(string $plan): array
    {
        return self::PLANS[$plan] ?? self::PLANS['free'];
    }

    public static function all(): array
    {
        return self::PLANS;
    }

    public static function price(string $plan, string $cycle = 'monthly'): float
    {
        $planData = self::get($plan);
        return $cycle === 'yearly' ? $planData['price_yearly'] : $planData['price_monthly'];
    }

    public static function discountPercent(): int
    {
        return 5; // 5% yearly discount
    }

    /**
     * Calculate the amount in the smallest currency unit (fils for OMR, 1 OMR = 1000 fils)
     */
    public static function amountInFils(string $plan, string $cycle = 'monthly'): int
    {
        return (int) (self::price($plan, $cycle) * 1000);
    }
}
