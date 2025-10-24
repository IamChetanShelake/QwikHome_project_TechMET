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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 255)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('AED');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded', 'partially_refunded']);
            $table->enum('type', ['payment', 'refund', 'authorization', 'capture', 'void']);

            $table->enum('provider', ['stripe', 'paypal', 'square', 'bank_transfer', 'cash', 'other']);
            $table->json('provider_response')->nullable(); // Full response from payment provider

            $table->text('description')->nullable();
            $table->text('failure_reason')->nullable();
            $table->decimal('refunded_amount', 10, 2)->default(0.00);
            $table->decimal('net_amount', 10, 2); // Amount after fees

            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['user_id']);
            $table->index(['booking_id']);
            $table->index(['subscription_id']);
            $table->index(['status']);
            $table->index(['type']);
            $table->index(['provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};