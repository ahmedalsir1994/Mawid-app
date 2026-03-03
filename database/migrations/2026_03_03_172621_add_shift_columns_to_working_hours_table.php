<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('working_hours', function (Blueprint $table) {
            if (!Schema::hasColumn('working_hours', 'first_shift_start')) {
                $table->time('first_shift_start')->nullable()->after('day_of_week');
            }
            if (!Schema::hasColumn('working_hours', 'first_shift_end')) {
                $table->time('first_shift_end')->nullable()->after('first_shift_start');
            }
            if (!Schema::hasColumn('working_hours', 'second_shift_start')) {
                $table->time('second_shift_start')->nullable()->after('first_shift_end');
            }
            if (!Schema::hasColumn('working_hours', 'second_shift_end')) {
                $table->time('second_shift_end')->nullable()->after('second_shift_start');
            }
        });
    }

    public function down(): void
    {
        Schema::table('working_hours', function (Blueprint $table) {
            $table->dropColumn(['first_shift_start', 'first_shift_end', 'second_shift_start', 'second_shift_end']);
        });
    }
};
