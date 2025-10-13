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
        Schema::create('combo_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('original_price', 10, 2); // Sum of individual service prices
            $table->decimal('combo_price', 10, 2); // Discounted combo price
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('fixed_discount', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('max_bookings_per_customer')->nullable(); // Limit per customer
            $table->integer('usage_limit')->nullable(); // Total usage limit
            $table->integer('used_count')->default(0);
            $table->json('terms_conditions')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired', 'draft'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->json('custom_fields')->nullable(); // For additional configurations
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_offers');
    }
};
