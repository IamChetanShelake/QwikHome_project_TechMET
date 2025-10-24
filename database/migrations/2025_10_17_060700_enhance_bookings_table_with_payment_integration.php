<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Payment-related fields
            $table->enum('payment_status', ['unpaid', 'paid', 'partially_paid', 'refunded', 'cancelled'])->default('unpaid')->after('status');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->onDelete('set null')->after('vendor_id');
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions')->onDelete('set null')->after('payment_method_id');

            // Financial fields
            $table->decimal('discount_amount', 10, 2)->default(0.00)->after('price');
            $table->decimal('tax_amount', 10, 2)->default(0.00)->after('discount_amount');
            $table->decimal('total_amount', 10, 2)->after('tax_amount');
            $table->decimal('paid_amount', 10, 2)->default(0.00)->after('total_amount');
            $table->decimal('refund_amount', 10, 2)->default(0.00)->after('paid_amount');
            $table->string('currency', 3)->default('AED')->after('refund_amount');
            $table->date('payment_due_date')->nullable()->after('currency');

            // Booking type and recurring support
            $table->enum('booking_type', ['onetime', 'subscription', 'recurring'])->default('onetime')->after('payment_due_date');
            $table->foreignId('parent_booking_id')->nullable()->constrained('bookings')->onDelete('set null')->after('booking_type');
            $table->date('next_booking_date')->nullable()->after('parent_booking_id');

            // Enhanced cancellation support
            $table->text('cancellation_reason')->nullable()->after('vendor_notes');
            $table->timestamp('cancelled_at')->nullable()->after('cancellation_reason');
            $table->decimal('cancellation_fee', 10, 2)->default(0.00)->after('cancelled_at');

            // Update existing price field to be required and initialize total_amount
            $table->decimal('total_amount', 10, 2)->nullable()->change();
        });

        // Initialize total_amount based on existing price data
        DB::statement('UPDATE bookings SET total_amount = COALESCE(price, 0) WHERE total_amount IS NULL');
        DB::statement('ALTER TABLE bookings MODIFY total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['subscription_id']);
            $table->dropForeign(['parent_booking_id']);

            // Drop columns
            $table->dropColumn([
                'payment_status',
                'payment_method_id',
                'subscription_id',
                'discount_amount',
                'tax_amount',
                'total_amount',
                'paid_amount',
                'refund_amount',
                'currency',
                'payment_due_date',
                'booking_type',
                'parent_booking_id',
                'next_booking_date',
                'cancellation_reason',
                'cancelled_at',
                'cancellation_fee'
            ]);

            // Restore original price field if needed
            $table->decimal('price', 10, 2)->nullable()->change();
        });
    }
};