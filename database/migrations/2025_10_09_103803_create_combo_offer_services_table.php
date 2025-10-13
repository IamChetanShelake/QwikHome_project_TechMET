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
        Schema::create('combo_offer_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combo_offer_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1); // How many times this service is included
            $table->enum('pricing_type', ['standard', 'included', 'discounted']); // How pricing works for this service in combo
            $table->decimal('custom_price', 10, 2)->nullable(); // Custom price for this service in combo
            $table->decimal('discount_percentage', 5, 2)->nullable(); // Discount applied to this specific service
            $table->json('custom_configurations')->nullable(); // Service-specific configurations
            $table->timestamps();

            // Ensure unique combo-service combinations
            $table->unique(['combo_offer_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_offer_services');
    }
};
