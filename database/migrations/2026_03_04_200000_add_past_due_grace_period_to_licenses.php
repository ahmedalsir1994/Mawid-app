<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Expand status enum to include 'past_due' and 'trial'
        DB::statement("ALTER TABLE licenses MODIFY COLUMN status ENUM('trial','active','past_due','expired','suspended','cancelled') DEFAULT 'active'");

        // Add grace period end date — set when status moves to past_due
        Schema::table('licenses', function (Blueprint $table) {
            if (!Schema::hasColumn('licenses', 'grace_period_ends_at')) {
                $table->date('grace_period_ends_at')->nullable()->after('past_due_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn('grace_period_ends_at');
        });

        DB::statement("ALTER TABLE licenses MODIFY COLUMN status ENUM('active','expired','suspended','cancelled') DEFAULT 'active'");
    }
};
