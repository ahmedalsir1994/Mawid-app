<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change billing_cycle from ENUM NOT NULL to nullable VARCHAR so custom licenses can store NULL
        DB::statement("ALTER TABLE licenses MODIFY COLUMN billing_cycle VARCHAR(10) NULL DEFAULT NULL");
    }

    public function down(): void
    {
        // Restore anything currently NULL to 'monthly' before making it NOT NULL again
        DB::table('licenses')->whereNull('billing_cycle')->update(['billing_cycle' => 'monthly']);
        DB::statement("ALTER TABLE licenses MODIFY COLUMN billing_cycle ENUM('monthly','yearly') NOT NULL DEFAULT 'monthly'");
    }
};
