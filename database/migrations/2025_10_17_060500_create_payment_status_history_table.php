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
        Schema::create('payment_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_transaction_id')->constrained('payment_transactions')->onDelete('cascade');
            $table->string('old_status', 50)->nullable();
            $table->string('new_status', 50);
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('change_reason')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->nullable();

            // Indexes
            $table->index(['payment_transaction_id']);
            $table->index(['changed_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_status_history');
    }
};