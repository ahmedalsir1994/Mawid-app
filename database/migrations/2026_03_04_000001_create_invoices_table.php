<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();   // INV-2026-000001
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();

            $table->string('plan');                       // free | pro | plus
            $table->string('billing_cycle');              // monthly | yearly
            $table->decimal('amount', 10, 3);             // in OMR
            $table->string('currency', 3)->default('OMR');
            $table->string('status')->default('paid');    // paid | failed | refunded

            $table->date('billing_period_start');
            $table->date('billing_period_end');
            $table->timestamp('paid_at')->nullable();

            $table->string('paymob_order_id')->nullable();
            $table->string('paymob_transaction_id')->nullable();

            // Snapshot of business at invoice time
            $table->string('business_name');
            $table->string('business_email')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
