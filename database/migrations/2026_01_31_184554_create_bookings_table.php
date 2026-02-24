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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();

            $table->string('customer_name');
            $table->string('customer_phone'); // store E.164 +968 / +966
            $table->enum('customer_country', ['OM', 'SA'])->nullable();

            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');

            $table->string('reference_code')->unique();
            $table->timestamp('reminder_sent_at')->nullable();

            $table->timestamps();

            $table->unique(['business_id', 'booking_date', 'start_time']); // prevents double booking (MVP)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};