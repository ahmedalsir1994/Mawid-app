<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // Landing page card control
            $table->json('features')->nullable()->after('whatsapp_reminders');           // e.g. ["Online Booking","WhatsApp Reminders"]
            $table->boolean('is_featured')->default(false)->after('features');           // highlights card (blue border + badge)
            $table->string('featured_label', 50)->default('Most Popular')->after('is_featured'); // badge text
            $table->string('cta_label', 100)->nullable()->after('featured_label');      // button text, e.g. "Start Pro →"
            $table->string('accent_color', 20)->default('gray')->after('cta_label');    // gray | blue | green
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['features', 'is_featured', 'featured_label', 'cta_label', 'accent_color']);
        });
    }
};
