<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change plan column from enum to nullable varchar so custom licenses can have plan = null
        DB::statement("ALTER TABLE licenses MODIFY COLUMN plan VARCHAR(20) NULL DEFAULT 'free'");

        Schema::table('licenses', function (Blueprint $table) {
            // License type: 'plan' uses standard plan limits; 'custom' has manually defined limits
            $table->enum('license_type', ['plan', 'custom'])
                  ->default('plan')
                  ->after('license_key');

            // Track which super admin created the license
            $table->foreignId('created_by')
                  ->nullable()
                  ->after('notes')
                  ->constrained('users')
                  ->onDelete('set null');
        });

        // All existing licenses are plan-based
        DB::table('licenses')->update(['license_type' => 'plan']);
    }

    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['license_type', 'created_by']);
        });

        DB::statement("ALTER TABLE licenses MODIFY COLUMN plan ENUM('free','pro','plus') NOT NULL DEFAULT 'free'");
    }
};
