<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 20)->unique();          // free, pro, plus
            $table->string('name', 50);
            $table->string('emoji', 10)->default('📋');
            $table->string('tagline')->nullable();

            // Pricing
            $table->decimal('price_monthly', 8, 3)->default(0);
            $table->decimal('price_yearly', 8, 3)->default(0);
            $table->decimal('price_monthly_display', 8, 3)->nullable(); // per-month equivalent on pricing card
            $table->decimal('price_yearly_display', 8, 3)->nullable();  // per-month equiv when billed yearly
            $table->decimal('old_price_monthly', 8, 3)->default(0);     // crossed-out price
            $table->decimal('old_price_yearly', 8, 3)->default(0);
            $table->unsignedTinyInteger('discount_monthly')->default(0); // %
            $table->unsignedTinyInteger('discount_yearly')->default(0);  // %

            // Limits (0 = unlimited)
            $table->unsignedSmallInteger('max_branches')->default(1);
            $table->unsignedSmallInteger('max_staff')->default(1);
            $table->unsignedSmallInteger('max_services')->default(0);
            $table->unsignedSmallInteger('max_daily_bookings')->default(0);
            $table->unsignedSmallInteger('max_monthly_bookings')->default(0);

            // Features
            $table->boolean('whatsapp_reminders')->default(false);

            // Meta
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
