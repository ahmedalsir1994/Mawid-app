<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->enum('plan', ['free', 'pro', 'plus'])->default('free')->after('license_key');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly')->after('plan');
            $table->integer('max_branches')->default(1)->after('max_daily_bookings');
            $table->integer('max_staff')->default(1)->after('max_branches');
            $table->integer('max_services')->default(3)->after('max_staff');
            $table->boolean('whatsapp_reminders')->default(false)->after('max_services');
            $table->string('paymob_order_id')->nullable()->after('notes');
        });

        // Synchronize existing licenses with plan defaults based on max_users
        // Existing trial/super-admin licenses get 'plus' equivalent
        \DB::table('licenses')->where('max_users', '>=', 5)->update([
            'plan'              => 'plus',
            'billing_cycle'     => 'monthly',
            'max_branches'      => 3,
            'max_staff'         => 15,
            'max_services'      => 999,
            'whatsapp_reminders'=> true,
        ]);
    }

    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn([
                'plan', 'billing_cycle', 'max_branches',
                'max_staff', 'max_services', 'whatsapp_reminders', 'paymob_order_id',
            ]);
        });
    }
};
