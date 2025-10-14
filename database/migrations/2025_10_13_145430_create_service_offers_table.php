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
        Schema::create('service_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'flat']);
            $table->decimal('discount_value', 10, 2);
            $table->decimal('discounted_price_onetime', 10, 2)->nullable();
            $table->decimal('discounted_price_weekly', 10, 2)->nullable();
            $table->decimal('discounted_price_monthly', 10, 2)->nullable();
            $table->decimal('discounted_price_yearly', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_offers');
    }
};
