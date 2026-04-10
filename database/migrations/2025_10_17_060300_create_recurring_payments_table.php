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
        Schema::create('recurring_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('user_subscriptions')->onDelete('cascade');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('AED');
            $table->enum('status', ['scheduled', 'processing', 'completed', 'failed', 'cancelled', 'skipped'])->default('scheduled');

            $table->date('scheduled_date');
            $table->date('processed_date')->nullable();
            $table->date('failed_date')->nullable();

            $table->tinyInteger('attempt_count')->default(0);
            $table->tinyInteger('max_attempts')->default(3);
            $table->date('next_retry_date')->nullable();

            $table->text('failure_reason')->nullable();
            $table->foreignId('transaction_id')->nullable()->constrained('payment_transactions')->onDelete('set null');

            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->json('metadata')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['subscription_id']);
            $table->index(['scheduled_date']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_payments');
    }
};