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
        Schema::create('subscription_billing_cycles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('user_subscriptions')->onDelete('cascade');
            $table->integer('cycle_number'); // 1, 2, 3, etc.
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'skipped', 'prorated'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('payment_transaction_id')->nullable()->constrained('payment_transactions')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['subscription_id']);
            $table->index(['cycle_number']);
            $table->index(['status']);

            // Ensure unique combination of subscription and cycle number
            $table->unique(['subscription_id', 'cycle_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_billing_cycles');
    }
};