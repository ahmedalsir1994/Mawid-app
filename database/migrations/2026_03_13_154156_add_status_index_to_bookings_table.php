<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Speed up status-filtered queries (e.g. upcoming pending/confirmed bookings)
            $table->index('status', 'bookings_status_idx');
            // Speed up reminder job queries (reminder_sent_at IS NULL)
            $table->index('reminder_sent_at', 'bookings_reminder_sent_at_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_status_idx');
            $table->dropIndex('bookings_reminder_sent_at_idx');
        });
    }
};
