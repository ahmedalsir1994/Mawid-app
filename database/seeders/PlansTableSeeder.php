<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'slug'                  => 'free',
                'name'                  => 'Free',
                'emoji'                 => '🆓',
                'tagline'               => 'For small solo shops testing the system',
                'price_monthly'         => 0,
                'price_yearly'          => 0,
                'price_monthly_display' => 0,
                'price_yearly_display'  => 0,
                'old_price_monthly'     => 0,
                'old_price_yearly'      => 0,
                'discount_monthly'      => 0,
                'discount_yearly'       => 0,
                'max_branches'          => 1,
                'max_staff'             => 1,
                'max_services'          => 3,
                'max_daily_bookings'    => 25,
                'max_monthly_bookings'  => 25,
                'whatsapp_reminders'    => true,
                'features'              => [
                    'Online Booking Page',
                    '24/7 Booking Access',
                    'Up to 3 Services',
                    '1 Staff Account',
                ],
                'is_featured'           => false,
                'featured_label'        => 'Most Popular',
                'cta_label'             => 'Get Started Free →',
                'accent_color'          => 'gray',
                'is_active'             => true,
                'sort_order'            => 0,
            ],
            [
                'slug'                  => 'pro',
                'name'                  => 'Pro',
                'emoji'                 => '💼',
                'tagline'               => 'For a real working shop',
                'price_monthly'         => 6.5,
                'price_yearly'          => 66.00,
                'price_monthly_display' => 6.5,
                'price_yearly_display'  => 5.5,
                'old_price_monthly'     => 10,
                'old_price_yearly'      => 120,
                'discount_monthly'      => 35,
                'discount_yearly'       => 45,
                'max_branches'          => 1,
                'max_staff'             => 3,
                'max_services'          => 15,
                'max_daily_bookings'    => 200,
                'max_monthly_bookings'  => 0,
                'whatsapp_reminders'    => true,
                'features'              => [
                    'Everything in Free',
                    'Up to 15 Services',
                    'Up to 3 Staff Accounts',
                    'Automated WhatsApp Reminders',
                    'Professional Workflow',
                ],
                'is_featured'           => true,
                'featured_label'        => 'Most Popular',
                'cta_label'             => 'Start Pro →',
                'accent_color'          => 'blue',
                'is_active'             => true,
                'sort_order'            => 1,
            ],
            [
                'slug'                  => 'plus',
                'name'                  => 'Plus',
                'emoji'                 => '🚀',
                'tagline'               => 'For growing businesses & multi-chair shops',
                'price_monthly'         => 9.8,
                'price_yearly'          => 109.20,
                'price_monthly_display' => 9.8,
                'price_yearly_display'  => 9.1,
                'old_price_monthly'     => 14,
                'old_price_yearly'      => 168,
                'discount_monthly'      => 30,
                'discount_yearly'       => 35,
                'max_branches'          => 3,
                'max_staff'             => 15,
                'max_services'          => 999,
                'max_daily_bookings'    => 999,
                'max_monthly_bookings'  => 0,
                'whatsapp_reminders'    => true,
                'features'              => [
                    'Everything in Pro',
                    '3 Branch Locations',
                    '5 Staff Per Branch',
                    'Unlimited Services',
                    'Priority Support',
                ],
                'is_featured'           => false,
                'featured_label'        => 'Most Popular',
                'cta_label'             => 'Start Plus →',
                'accent_color'          => 'green',
                'is_active'             => true,
                'sort_order'            => 2,
            ],
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(['slug' => $planData['slug']], $planData);
        }
    }
}
