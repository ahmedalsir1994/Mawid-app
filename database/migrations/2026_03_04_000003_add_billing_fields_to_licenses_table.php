<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            if (!Schema::hasColumn('licenses', 'auto_renew')) {
                $table->boolean('auto_renew')->default(true)->after('payment_status');
            }
            if (!Schema::hasColumn('licenses', 'next_billing_date')) {
                $table->date('next_billing_date')->nullable()->after('expires_at');
            }
            if (!Schema::hasColumn('licenses', 'past_due_at')) {
                $table->timestamp('past_due_at')->nullable()->after('next_billing_date');
            }
            if (!Schema::hasColumn('licenses', 'auto_renew_attempts')) {
                $table->unsignedTinyInteger('auto_renew_attempts')->default(0)->after('past_due_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('licenses', function (Blueprint $table) {
            $table->dropColumn(['auto_renew', 'next_billing_date', 'past_due_at', 'auto_renew_attempts']);
        });
    }
};
