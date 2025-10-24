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
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('payment_transaction_id')->constrained('payment_transactions')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->boolean('is_refund')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['booking_id']);
            $table->index(['payment_transaction_id']);

            // Ensure unique combination of booking and transaction
            $table->unique(['booking_id', 'payment_transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payments');
    }
};