<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Drop the unique constraint on (staff_user_id, booking_date, start_time).
 *
 * Reason: the constraint does not account for booking status, so a cancelled
 * booking permanently blocks re-booking that slot for the same staff member.
 * Duplicate-booking protection is handled entirely at the application layer
 * in ManualBookingController::store() and PublicBookingController::store(),
 * both of which correctly exclude cancelled/completed bookings from their
 * overlap queries.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // MySQL uses the unique index to back the FK; we must add a plain index
            // first so the FK still has an index after we drop the unique constraint.
            $table->index('staff_user_id', 'bookings_staff_user_id_idx');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique('bookings_staff_time_unique');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unique(['staff_user_id', 'booking_date', 'start_time'], 'bookings_staff_time_unique');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bookings_staff_user_id_idx');
        });
    }
};
