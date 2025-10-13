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
        Schema::create('service_subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->json('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->foreignId('billing_frequency_id')->constrained('service_frequencies');
            $table->integer('duration_months'); // Duration of the subscription plan
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'yearly'])->default('monthly');
            $table->decimal('setup_fee', 10, 2)->default(0);
            $table->boolean('auto_renew')->default(true);
            $table->integer('renewal_reminder_days')->default(7);
            $table->json('included_addons')->nullable(); // Array of addon IDs included in this plan
            $table->decimal('discount_percentage', 5, 2)->default(0); // Discount from regular price
            $table->integer('max_services_per_period')->default(1); // Max services allowed in billing period
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->json('custom_configurations')->nullable(); // Additional custom settings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_subscription_plans');
    }
};
