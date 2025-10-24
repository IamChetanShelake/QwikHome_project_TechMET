# Enhanced Booking, Payment & Subscription System Design

## Current System Analysis

### Existing Infrastructure:
- **Basic booking system** with service, customer, service provider, vendor relationships
- **Service subscription plans** for recurring services
- **Cart system** with subscription support
- **Vendor payment terms** (fixed_rate, commission, revenue_share)
- **Basic price tracking** at booking level

### Missing Components:
- **Payment processing and tracking**
- **User subscription management**
- **Payment transaction history**
- **Recurring payment handling**
- **Multiple payment methods support**

## Enhanced Database Schema Design

### 1. Enhanced Bookings Table
```sql
-- Enhanced bookings table with payment integration
ALTER TABLE `bookings` ADD COLUMN (
    `payment_status` ENUM('unpaid', 'paid', 'partially_paid', 'refunded', 'cancelled') DEFAULT 'unpaid',
    `payment_method_id` BIGINT UNSIGNED NULL,
    `subscription_id` BIGINT UNSIGNED NULL,
    `discount_amount` DECIMAL(10,2) DEFAULT 0.00,
    `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
    `total_amount` DECIMAL(10,2) NOT NULL,
    `paid_amount` DECIMAL(10,2) DEFAULT 0.00,
    `refund_amount` DECIMAL(10,2) DEFAULT 0.00,
    `currency` VARCHAR(3) DEFAULT 'AED',
    `payment_due_date` DATE NULL,
    `booking_type` ENUM('onetime', 'subscription', 'recurring') DEFAULT 'onetime',
    `parent_booking_id` BIGINT UNSIGNED NULL, -- For recurring bookings
    `next_booking_date` DATE NULL,
    `cancellation_reason` TEXT NULL,
    `cancelled_at` TIMESTAMP NULL,
    `cancellation_fee` DECIMAL(10,2) DEFAULT 0.00
);

-- Add foreign key constraints
ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_payment_method`
    FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods`(`id`) ON DELETE SET NULL;

ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_subscription`
    FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions`(`id`) ON DELETE SET NULL;

ALTER TABLE `bookings` ADD CONSTRAINT `fk_bookings_parent_booking`
    FOREIGN KEY (`parent_booking_id`) REFERENCES `bookings`(`id`) ON DELETE SET NULL;
```

### 2. Payment Methods Table
```sql
CREATE TABLE `payment_methods` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `type` ENUM('credit_card', 'debit_card', 'bank_transfer', 'digital_wallet', 'cash', 'other') NOT NULL,
    `provider` ENUM('stripe', 'paypal', 'square', 'bank_transfer', 'cash', 'other') NOT NULL,
    `is_default` TINYINT(1) DEFAULT 0,
    `is_active` TINYINT(1) DEFAULT 1,

    -- Credit/Debit Card fields
    `card_last_four` VARCHAR(4) NULL,
    `card_brand` VARCHAR(50) NULL,
    `card_exp_month` TINYINT NULL,
    `card_exp_year` SMALLINT NULL,
    `card_token` VARCHAR(255) NULL, -- Encrypted token

    -- Bank Transfer fields
    `bank_name` VARCHAR(255) NULL,
    `account_number` VARCHAR(255) NULL,
    `routing_number` VARCHAR(255) NULL,
    `iban` VARCHAR(255) NULL,

    -- Digital Wallet fields
    `wallet_type` VARCHAR(50) NULL, -- apple_pay, google_pay, etc.
    `wallet_identifier` VARCHAR(255) NULL,

    -- Billing Address
    `billing_name` VARCHAR(255) NULL,
    `billing_email` VARCHAR(255) NULL,
    `billing_phone` VARCHAR(255) NULL,
    `billing_address` TEXT NULL,
    `billing_city` VARCHAR(255) NULL,
    `billing_state` VARCHAR(255) NULL,
    `billing_zip` VARCHAR(20) NULL,
    `billing_country` VARCHAR(100) NULL,

    `metadata` JSON NULL, -- Additional provider-specific data
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    INDEX `idx_payment_methods_user_type` (`user_id`, `type`),
    INDEX `idx_payment_methods_default` (`user_id`, `is_default`),
    CONSTRAINT `fk_payment_methods_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
```

### 3. Payment Transactions Table
```sql
CREATE TABLE `payment_transactions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `transaction_id` VARCHAR(255) NOT NULL UNIQUE, -- External provider transaction ID
    `user_id` BIGINT UNSIGNED NOT NULL,
    `booking_id` BIGINT UNSIGNED NULL,
    `subscription_id` BIGINT UNSIGNED NULL,
    `payment_method_id` BIGINT UNSIGNED NOT NULL,

    `amount` DECIMAL(10,2) NOT NULL,
    `currency` VARCHAR(3) DEFAULT 'AED',
    `status` ENUM('pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded', 'partially_refunded') NOT NULL,
    `type` ENUM('payment', 'refund', 'authorization', 'capture', 'void') NOT NULL,

    `provider` ENUM('stripe', 'paypal', 'square', 'bank_transfer', 'cash', 'other') NOT NULL,
    `provider_response` JSON NULL, -- Full response from payment provider

    `description` TEXT NULL,
    `failure_reason` TEXT NULL,
    `refunded_amount` DECIMAL(10,2) DEFAULT 0.00,
    `net_amount` DECIMAL(10,2) NOT NULL, -- Amount after fees

    `processed_at` TIMESTAMP NULL,
    `completed_at` TIMESTAMP NULL,
    `failed_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    INDEX `idx_payment_transactions_user` (`user_id`),
    INDEX `idx_payment_transactions_booking` (`booking_id`),
    INDEX `idx_payment_transactions_subscription` (`subscription_id`),
    INDEX `idx_payment_transactions_status` (`status`),
    INDEX `idx_payment_transactions_type` (`type`),
    INDEX `idx_payment_transactions_provider` (`provider`),

    CONSTRAINT `fk_payment_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_payment_transactions_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_payment_transactions_subscription` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_payment_transactions_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods`(`id`) ON DELETE CASCADE
);
```

### 4. User Subscriptions Table
```sql
CREATE TABLE `user_subscriptions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `subscription_plan_id` BIGINT UNSIGNED NOT NULL,
    `service_id` BIGINT UNSIGNED NOT NULL,

    `subscription_number` VARCHAR(50) NOT NULL UNIQUE,
    `status` ENUM('active', 'paused', 'cancelled', 'expired', 'pending') DEFAULT 'active',

    `start_date` DATE NOT NULL,
    `end_date` DATE NULL,
    `trial_end_date` DATE NULL,
    `cancelled_at` TIMESTAMP NULL,
    `cancellation_reason` TEXT NULL,

    `billing_cycle` ENUM('weekly', 'monthly', 'quarterly', 'yearly') NOT NULL,
    `billing_day` TINYINT NOT NULL, -- Day of month/week for billing (1-31 or 1-7)

    `base_price` DECIMAL(10,2) NOT NULL,
    `discount_amount` DECIMAL(10,2) DEFAULT 0.00,
    `tax_amount` DECIMAL(10,2) DEFAULT 0.00,
    `total_amount` DECIMAL(10,2) NOT NULL,

    `auto_renew` TINYINT(1) DEFAULT 1,
    `next_billing_date` DATE NOT NULL,
    `failed_payment_count` TINYINT DEFAULT 0,
    `max_failed_payments` TINYINT DEFAULT 3,

    `payment_method_id` BIGINT UNSIGNED NOT NULL,
    `last_payment_date` DATE NULL,
    `last_payment_amount` DECIMAL(10,2) NULL,

    `metadata` JSON NULL, -- Custom configurations, addons, etc.
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    INDEX `idx_user_subscriptions_user` (`user_id`),
    INDEX `idx_user_subscriptions_service` (`service_id`),
    INDEX `idx_user_subscriptions_plan` (`subscription_plan_id`),
    INDEX `idx_user_subscriptions_status` (`status`),
    INDEX `idx_user_subscriptions_next_billing` (`next_billing_date`),

    CONSTRAINT `fk_user_subscriptions_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_subscriptions_plan` FOREIGN KEY (`subscription_plan_id`) REFERENCES `service_subscription_plans`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_subscriptions_service` FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_subscriptions_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods`(`id`) ON DELETE CASCADE
);
```

### 5. Subscription Plans Table (Enhanced)
```sql
-- Enhance existing service_subscription_plans table
ALTER TABLE `service_subscription_plans` ADD COLUMN (
    `is_popular` TINYINT(1) DEFAULT 0,
    `is_featured` TINYINT(1) DEFAULT 1,
    `sort_order` INT DEFAULT 0,
    `max_concurrent_bookings` INT DEFAULT 1,
    `grace_period_days` INT DEFAULT 3,
    `trial_period_days` INT DEFAULT 0,
    `setup_fee` DECIMAL(10,2) DEFAULT 0.00,
    `cancellation_fee` DECIMAL(10,2) DEFAULT 0.00,
    `proration_enabled` TINYINT(1) DEFAULT 1,
    `upgrade_downgrade_allowed` TINYINT(1) DEFAULT 1,
    `pause_resume_allowed` TINYINT(1) DEFAULT 1,
    `terms_conditions` TEXT NULL,
    `features` JSON NULL, -- Array of features included in plan
    `limitations` JSON NULL -- Array of limitations/restrictions
);
```

### 6. Recurring Payments Table
```sql
CREATE TABLE `recurring_payments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `subscription_id` BIGINT UNSIGNED NOT NULL,
    `booking_id` BIGINT UNSIGNED NULL,

    `amount` DECIMAL(10,2) NOT NULL,
    `currency` VARCHAR(3) DEFAULT 'AED',
    `status` ENUM('scheduled', 'processing', 'completed', 'failed', 'cancelled', 'skipped') DEFAULT 'scheduled',

    `scheduled_date` DATE NOT NULL,
    `processed_date` DATE NULL,
    `failed_date` DATE NULL,

    `attempt_count` TINYINT DEFAULT 0,
    `max_attempts` TINYINT DEFAULT 3,
    `next_retry_date` DATE NULL,

    `failure_reason` TEXT NULL,
    `transaction_id` BIGINT UNSIGNED NULL, -- Links to payment_transactions

    `payment_method_id` BIGINT UNSIGNED NOT NULL,
    `metadata` JSON NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    INDEX `idx_recurring_payments_subscription` (`subscription_id`),
    INDEX `idx_recurring_payments_scheduled` (`scheduled_date`),
    INDEX `idx_recurring_payments_status` (`status`),

    CONSTRAINT `fk_recurring_payments_subscription` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_recurring_payments_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_recurring_payments_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `payment_transactions`(`id`) ON DELETE SET NULL,
    CONSTRAINT `fk_recurring_payments_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods`(`id`) ON DELETE CASCADE
);
```

### 7. Booking Payments Junction Table
```sql
CREATE TABLE `booking_payments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `booking_id` BIGINT UNSIGNED NOT NULL,
    `payment_transaction_id` BIGINT UNSIGNED NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `is_refund` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    INDEX `idx_booking_payments_booking` (`booking_id`),
    INDEX `idx_booking_payments_transaction` (`payment_transaction_id`),

    CONSTRAINT `fk_booking_payments_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_booking_payments_transaction` FOREIGN KEY (`payment_transaction_id`) REFERENCES `payment_transactions`(`id`) ON DELETE CASCADE,

    UNIQUE KEY `unique_booking_transaction` (`booking_id`, `payment_transaction_id`)
);
```

### 8. Payment Status History Table
```sql
CREATE TABLE `payment_status_history` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `payment_transaction_id` BIGINT UNSIGNED NOT NULL,
    `old_status` VARCHAR(50) NULL,
    `new_status` VARCHAR(50) NOT NULL,
    `changed_by` BIGINT UNSIGNED NULL, -- User ID or system
    `change_reason` TEXT NULL,
    `metadata` JSON NULL,
    `created_at` TIMESTAMP NULL,

    INDEX `idx_payment_status_history_transaction` (`payment_transaction_id`),
    INDEX `idx_payment_status_history_changed_by` (`changed_by`),

    CONSTRAINT `fk_payment_status_history_transaction` FOREIGN KEY (`payment_transaction_id`) REFERENCES `payment_transactions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_payment_status_history_user` FOREIGN KEY (`changed_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
);
```

### 9. Subscription Billing Cycles Table
```sql
CREATE TABLE `subscription_billing_cycles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `subscription_id` BIGINT UNSIGNED NOT NULL,
    `cycle_number` INT NOT NULL, -- 1, 2, 3, etc.
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `status` ENUM('pending', 'paid', 'failed', 'skipped', 'prorated') DEFAULT 'pending',
    `paid_at` TIMESTAMP NULL,
    `payment_transaction_id` BIGINT UNSIGNED NULL,
    `notes` TEXT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,

    INDEX `idx_subscription_billing_subscription` (`subscription_id`),
    INDEX `idx_subscription_billing_cycle` (`cycle_number`),
    INDEX `idx_subscription_billing_status` (`status`),

    CONSTRAINT `fk_subscription_billing_subscription` FOREIGN KEY (`subscription_id`) REFERENCES `user_subscriptions`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_subscription_billing_transaction` FOREIGN KEY (`payment_transaction_id`) REFERENCES `payment_transactions`(`id`) ON DELETE SET NULL,

    UNIQUE KEY `unique_subscription_cycle` (`subscription_id`, `cycle_number`)
);
```

## Database Relationships Summary

```
users (1) ──── (many) bookings
users (1) ──── (many) payment_methods
users (1) ──── (many) user_subscriptions
users (1) ──── (many) payment_transactions

bookings (many) ──── (many) payment_transactions (through booking_payments)
bookings (1) ──── (many) bookings (parent-child for recurring)

services (1) ──── (many) user_subscriptions
service_subscription_plans (1) ──── (many) user_subscriptions

payment_methods (1) ──── (many) payment_transactions
payment_transactions (1) ──── (many) payment_status_history
payment_transactions (1) ──── (many) recurring_payments

user_subscriptions (1) ──── (many) subscription_billing_cycles
user_subscriptions (1) ──── (many) recurring_payments
user_subscriptions (1) ──── (many) bookings
```

## Key Features Supported

1. **Multiple Payment Methods**: Credit cards, bank transfers, digital wallets
2. **Subscription Management**: Flexible billing cycles, pause/resume, upgrades/downgrades
3. **Recurring Payments**: Automated billing for subscriptions
4. **Payment Tracking**: Complete transaction history with status updates
5. **Booking Integration**: Seamless payment flow for bookings
6. **Refund Management**: Partial and full refunds with tracking
7. **Multi-currency Support**: Extensible for different currencies
8. **Audit Trail**: Complete history of all payment-related changes

This design provides a comprehensive foundation for handling payments and subscriptions while maintaining flexibility for future enhancements.