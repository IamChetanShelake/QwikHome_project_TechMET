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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');

            // Item type polymorphism
            $table->enum('item_type', ['service', 'subscription_plan', 'combo_offer', 'addon_only']);
            $table->unsignedBigInteger('item_id'); // ID of the actual item

            // Core item details
            $table->string('item_name');
            $table->json('item_description')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2); // unit_price * quantity * modifiers

            // Service-specific configurations
            $table->foreignId('service_frequency_id')->nullable()->constrained()->onDelete('set null'); // Which frequency user chose
            $table->date('scheduled_date')->nullable(); // For individual bookings
            $table->time('preferred_time')->nullable(); // For scheduling

            // Subscription-specific fields
            $table->foreignId('subscription_plan_id')->nullable()->constrained('service_subscription_plans')->onDelete('cascade');
            $table->boolean('auto_renew')->nullable();

            // Combo offer fields
            $table->foreignId('combo_offer_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('combo_services_config')->nullable(); // Custom configurations for each service in combo
            $table->json('combo_discount_applied')->nullable(); // Discount breakdown for combo

            // Add-ons and customizations
            $table->json('selected_addons')->nullable(); // Array of addon IDs with quantities/configs
            $table->json('addon_details')->nullable(); // Detailed addon information with pricing

            // Pricing and discounts
            $table->decimal('base_price', 10, 2); // Price before any customizations
            $table->decimal('addons_price', 10, 2)->default(0); // Total price of add-ons
            $table->decimal('discount_amount', 10, 2)->default(0); // Discount applied to this item
            $table->string('discount_reason')->nullable(); // Why discount was applied
            $table->decimal('tax_amount', 10, 2)->default(0);

            // Custom configurations
            $table->json('custom_configurations')->nullable(); // Service-specific custom settings
            $table->json('customer_notes')->nullable();
            $table->json('special_requirements')->nullable();

            // Service provider selection
            $table->foreignId('preferred_service_provider_id')->nullable()->constrained('users')->onDelete('set null');

            // Status and metadata
            $table->enum('status', ['active', 'removed', 'saved_for_later'])->default('active');
            $table->json('item_metadata')->nullable(); // Additional item-level data
            $table->timestamps();

            // Indexes for performance
            $table->index(['item_type', 'item_id']);
            $table->index('cart_id');
            $table->index('subscription_plan_id');
            $table->index('combo_offer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
