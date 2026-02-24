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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();

            $table->enum('country', ['OM', 'SA'])->default('OM');
            $table->string('timezone')->default('Asia/Muscat'); // OM default
            $table->enum('currency', ['OMR', 'SAR'])->default('OMR');

            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            $table->enum('default_language', ['ar', 'en'])->default('ar');

            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};