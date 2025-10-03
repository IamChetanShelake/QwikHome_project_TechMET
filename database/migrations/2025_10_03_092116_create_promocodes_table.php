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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->decimal('discount', 10, 2); // float value as discount
            $table->boolean('for_active_subscription')->default(true); // only for active subscription users
            $table->boolean('is_used')->default(false); // usable once, so track if used
            $table->dateTime('expiry_date')->nullable(); // optional expiry
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocodes');
    }
};
