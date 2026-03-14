<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First convert the enum column to a plain string so it can hold any country code.
        // Using raw SQL is the safest approach across MySQL/MariaDB versions.
        DB::statement('ALTER TABLE businesses MODIFY COLUMN country VARCHAR(10) NOT NULL DEFAULT \'OM\'');

        Schema::table('businesses', function (Blueprint $table) {
            $table->string('google_maps_location')->nullable()->after('address');
            $table->string('how_heard_about_us', 60)->nullable()->after('google_maps_location');
        });
    }

    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn(['google_maps_location', 'how_heard_about_us']);
        });

        // Revert to original enum (best-effort; data outside OM/SA will be lost on rollback)
        DB::statement("ALTER TABLE businesses MODIFY COLUMN country ENUM('OM','SA') NOT NULL DEFAULT 'OM'");
    }
};
