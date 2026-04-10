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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_plan_id')->constrained('service_subscription_plans')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');

            $table->string('subscription_number', 50)->unique();
            $table->enum('status', ['active', 'paused', 'cancelled', 'expired', 'pending'])->default('active');

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('trial_end_date')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

            $table->enum('billing_cycle', ['weekly', 'monthly', 'quarterly', 'yearly']);
            $table->tinyInteger('billing_day'); // Day of month/week for billing (1-31 or 1-7)

            $table->decimal('base_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('tax_amount', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2);

            $table->boolean('auto_renew')->default(true);
            $table->date('next_billing_date');
            $table->tinyInteger('failed_payment_count')->default(0);
            $table->tinyInteger('max_failed_payments')->default(3);

            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->date('last_payment_date')->nullable();
            $table->decimal('last_payment_amount', 10, 2)->nullable();

            $table->json('metadata')->nullable(); // Custom configurations, addons, etc.
            $table->timestamps();

            // Indexes
            $table->index(['user_id']);
            $table->index(['service_id']);
            $table->index(['subscription_plan_id']);
            $table->index(['status']);
            $table->index(['next_billing_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};