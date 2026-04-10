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
        Schema::table('service_subscription_plans', function (Blueprint $table) {
            // Enhanced subscription plan features
            $table->boolean('is_popular')->default(false)->after('status');
            $table->boolean('is_featured')->default(true)->after('is_popular');
            $table->integer('sort_order')->default(0)->after('is_featured');
            $table->integer('max_concurrent_bookings')->default(1)->after('sort_order');
            $table->integer('grace_period_days')->default(3)->after('max_concurrent_bookings');
            $table->integer('trial_period_days')->default(0)->after('grace_period_days');

            // Financial enhancements
            $table->decimal('setup_fee', 10, 2)->default(0.00)->after('trial_period_days');
            $table->decimal('cancellation_fee', 10, 2)->default(0.00)->after('setup_fee');

            // Subscription management features
            $table->boolean('proration_enabled')->default(true)->after('cancellation_fee');
            $table->boolean('upgrade_downgrade_allowed')->default(true)->after('proration_enabled');
            $table->boolean('pause_resume_allowed')->default(true)->after('upgrade_downgrade_allowed');

            // Content and features
            $table->text('terms_conditions')->nullable()->after('pause_resume_allowed');
            $table->json('features')->nullable()->after('terms_conditions'); // Array of features included in plan
            $table->json('limitations')->nullable()->after('features'); // Array of limitations/restrictions
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'is_popular',
                'is_featured',
                'sort_order',
                'max_concurrent_bookings',
                'grace_period_days',
                'trial_period_days',
                'setup_fee',
                'cancellation_fee',
                'proration_enabled',
                'upgrade_downgrade_allowed',
                'pause_resume_allowed',
                'terms_conditions',
                'features',
                'limitations'
            ]);
        });
    }
};