<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add staff assignment column first
            $table->foreignId('staff_user_id')->nullable()->after('service_id')->constrained('users')->cascadeOnDelete();
        });
        
        // Drop the foreign key constraint temporarily to remove the unique index
        DB::statement('ALTER TABLE bookings DROP FOREIGN KEY bookings_business_id_foreign');
        
        // Drop the old unique constraint
        DB::statement('ALTER TABLE bookings DROP INDEX bookings_business_id_booking_date_start_time_unique');
        
        // Recreate the foreign key constraint
        DB::statement('ALTER TABLE bookings ADD CONSTRAINT bookings_business_id_foreign FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE');
        
        // Add new unique constraint (staff-level) - allows multiple staff to have bookings at same time
        Schema::table('bookings', function (Blueprint $table) {
            $table->unique(['staff_user_id', 'booking_date', 'start_time'], 'bookings_staff_time_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the staff-level unique constraint
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique('bookings_staff_time_unique');
        });
        
        // Drop and recreate the business_id foreign key to add back the old constraint
        DB::statement('ALTER TABLE bookings DROP FOREIGN KEY bookings_business_id_foreign');
        
        // Restore the old business-level unique constraint
        DB::statement('ALTER TABLE bookings ADD UNIQUE bookings_business_id_booking_date_start_time_unique (business_id, booking_date, start_time)');
        
        // Recreate the foreign key
        DB::statement('ALTER TABLE bookings ADD CONSTRAINT bookings_business_id_foreign FOREIGN KEY (business_id) REFERENCES businesses(id) ON DELETE CASCADE');
        
        // Drop the staff_user_id column
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['staff_user_id']);
            $table->dropColumn('staff_user_id');
        });
    }
};
