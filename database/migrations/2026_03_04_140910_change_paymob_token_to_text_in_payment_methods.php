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
        // Laravel's 'encrypted' cast produces ~300-500 char Base64 ciphertext,
        // so varchar(255) is too short — widen to TEXT.
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->text('paymob_token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('paymob_token')->nullable()->change();
        });
    }
};
