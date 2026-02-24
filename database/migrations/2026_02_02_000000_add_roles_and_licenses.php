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
        // Add role column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'company_admin', 'staff', 'customer'])->default('customer')->after('password');
            $table->boolean('is_active')->default(true)->after('role');
        });

        // Create licenses table
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('license_key')->unique();
            $table->enum('status', ['active', 'expired', 'suspended', 'cancelled'])->default('active');
            $table->integer('max_users')->default(5);
            $table->integer('max_daily_bookings')->default(100);
            $table->date('activated_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('payment_status')->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('status');
            $table->index('business_id');
        });

        // Add business_id to users table if not exists
        if (!Schema::hasColumn('users', 'business_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('business_id')->nullable()->constrained()->onDelete('set null')->after('is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['business_id']);
            $table->dropColumn(['business_id', 'is_active', 'role']);
        });

        Schema::dropIfExists('licenses');
    }
};
