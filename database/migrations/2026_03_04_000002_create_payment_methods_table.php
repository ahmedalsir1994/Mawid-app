<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();

            // Paymob card token (for recurring charges)
            $table->string('paymob_token')->nullable();

            // Card display info (no raw card data stored)
            $table->string('card_brand')->nullable();    // Visa, MasterCard
            $table->string('last_four')->nullable();     // e.g. 4242
            $table->string('expiry_month')->nullable();  // e.g. 12
            $table->string('expiry_year')->nullable();   // e.g. 2028
            $table->string('cardholder_name')->nullable();

            $table->boolean('is_default')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
