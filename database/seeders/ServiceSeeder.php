<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories
        $coreHomeServices = Category::create([
            'name' => 'Core Home Services',
            'description' => 'Essential cleaning, maintenance, and home care services',
            'status' => 'active'
        ]);

        $familySupport = Category::create([
            'name' => 'Family Support',
            'description' => 'Support services for families including childcare and assistance',
            'status' => 'active'
        ]);

        $personalCare = Category::create([
            'name' => 'Personal Care',
            'description' => 'Beauty, grooming, and personal wellness services',
            'status' => 'active'
        ]);

        $homeMaintenance = Category::create([
            'name' => 'Home Maintenance & Interior',
            'description' => 'Home improvement, repairs, and maintenance services',
            'status' => 'active'
        ]);

        $vehicleLegal = Category::create([
            'name' => 'Vehicle & Legal Services',
            'description' => 'Vehicle maintenance and legal assistance services',
            'status' => 'active'
        ]);

        $lifestyleEvents = Category::create([
            'name' => 'Lifestyle & Events',
            'description' => 'Event planning and lifestyle enhancement services',
            'status' => 'active'
        ]);

        // Core Home Services Subcategories & Services
        $cleaningServices = Subcategory::create([
            'category_id' => $coreHomeServices->id,
            'name' => 'Cleaning Services',
            'description' => 'Professional cleaning and hygiene services',
            'status' => 'active'
        ]);

        $laundryServices = Subcategory::create([
            'category_id' => $coreHomeServices->id,
            'name' => 'Laundry Services',
            'description' => 'Clothing and fabric care services',
            'status' => 'active'
        ]);

        $pestDisinfection = Subcategory::create([
            'category_id' => $coreHomeServices->id,
            'name' => 'Pest & Disinfection Services',
            'description' => 'Pest control and disinfection services',
            'status' => 'active'
        ]);

        $movingServices = Subcategory::create([
            'category_id' => $coreHomeServices->id,
            'name' => 'Moving & Relocation Services',
            'description' => 'Professional moving and relocation assistance',
            'status' => 'active'
        ]);

        // Cleaning Services
        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $cleaningServices->id,
            'name' => 'Maids – Subscription & on-demand cleaning',
            'description' => 'Professional house cleaning services available on subscription or one-time basis',
            'price' => 500.00,
            'duration' => '2-4 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $cleaningServices->id,
            'name' => 'Deep Cleaning – Kitchen, bathroom, full home',
            'description' => 'Thorough deep cleaning of kitchen, bathroom, and entire home',
            'price' => 2000.00,
            'duration' => '4-6 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $cleaningServices->id,
            'name' => 'Move-in/Move-out Cleaning',
            'description' => 'Specialized cleaning service for property transitions',
            'price' => 3000.00,
            'duration' => '6-8 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $cleaningServices->id,
            'name' => 'Refrigerator Cleaning',
            'description' => 'Professional refrigerator deep cleaning and sanitization',
            'price' => 800.00,
            'duration' => '2 hours',
            'status' => 'active'
        ]);

        // Laundry Services
        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $laundryServices->id,
            'name' => 'Laundry at Home – Ironing, folding, wardrobe assistance',
            'description' => 'Complete laundry service including ironing, folding, and wardrobe organization',
            'price' => 600.00,
            'duration' => '3-4 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $laundryServices->id,
            'name' => 'Laundry Collection – Clothes, carpets, shoes',
            'description' => 'Professional laundry collection service for clothes, carpets, and shoes',
            'price' => 300.00,
            'duration' => '2 hours',
            'status' => 'active'
        ]);

        // Pest & Disinfection Services
        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $pestDisinfection->id,
            'name' => 'Pest Control',
            'description' => 'Professional pest management and extermination services',
            'price' => 1500.00,
            'duration' => '2-3 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $pestDisinfection->id,
            'name' => 'Disinfection Services',
            'description' => 'Complete disinfection and sanitization of home spaces',
            'price' => 1000.00,
            'duration' => '2-3 hours',
            'status' => 'active'
        ]);

        // Moving & Relocation Services
        Service::create([
            'category_id' => $coreHomeServices->id,
            'subcategory_id' => $movingServices->id,
            'name' => 'Movers and Packers for home/office relocation',
            'description' => 'Professional moving and packing services for home or office relocation',
            'price' => 5000.00,
            'duration' => 'Full day',
            'status' => 'active'
        ]);

        // Family Support Subcategories & Services
        $childCare = Subcategory::create([
            'category_id' => $familySupport->id,
            'name' => 'Child Care',
            'description' => 'Childcare and nanny services',
            'status' => 'active'
        ]);

        $postMaternityCare = Subcategory::create([
            'category_id' => $familySupport->id,
            'name' => 'Post-Maternity Care',
            'description' => 'Post-delivery maternal care and assistance',
            'status' => 'active'
        ]);

        $educationSupport = Subcategory::create([
            'category_id' => $familySupport->id,
            'name' => 'Education Support',
            'description' => 'Tutoring and educational assistance services',
            'status' => 'active'
        ]);

        $foodServices = Subcategory::create([
            'category_id' => $familySupport->id,
            'name' => 'Food Services',
            'description' => 'Home cooking and meal preparation services',
            'status' => 'active'
        ]);

        $transportation = Subcategory::create([
            'category_id' => $familySupport->id,
            'name' => 'Transportation',
            'description' => 'Family transportation and driver services',
            'status' => 'active'
        ]);

        // Child Care Services
        Service::create([
            'category_id' => $familySupport->id,
            'subcategory_id' => $childCare->id,
            'name' => 'Nanny Services',
            'description' => 'Professional childcare and nanny services for families',
            'price' => 800.00,
            'duration' => '4-8 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $familySupport->id,
            'subcategory_id' => $postMaternityCare->id,
            'name' => 'Post-Maternity Care Staff',
            'description' => 'Post-delivery maternal care and newborn assistance',
            'price' => 1200.00,
            'duration' => '12-24 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $familySupport->id,
            'subcategory_id' => $educationSupport->id,
            'name' => 'Home Tutor',
            'description' => 'Professional home tutoring services for all subjects and grades',
            'price' => 600.00,
            'duration' => '2 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $familySupport->id,
            'subcategory_id' => $foodServices->id,
            'name' => 'Cook Services – 2 meals/day, 2-hour schedule',
            'description' => 'Home cooking service providing 2 meals per day with 2-hour schedule',
            'price' => 1000.00,
            'duration' => '2 hours',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $familySupport->id,
            'subcategory_id' => $transportation->id,
            'name' => 'Driver on Demand – 6-hour or overnight',
            'description' => 'On-demand driver services for 6-hour shifts or overnight requirements',
            'price' => 1500.00,
            'duration' => '6-24 hours',
            'status' => 'active'
        ]);

        // Personal Care Subcategories & Services
        $salonServices = Subcategory::create([
            'category_id' => $personalCare->id,
            'name' => 'Salon Services',
            'description' => 'Professional hair, beauty, and grooming services',
            'status' => 'active'
        ]);

        $spaServices = Subcategory::create([
            'category_id' => $personalCare->id,
            'name' => 'Spa Services',
            'description' => 'Relaxation and wellness spa treatments',
            'status' => 'active'
        ]);

        // Salon Services
        Service::create([
            'category_id' => $personalCare->id,
            'subcategory_id' => $salonServices->id,
            'name' => 'Salon Services – Unisex + kids (hair, waxing, facial, grooming)',
            'description' => 'Complete salon services including hair, waxing, facial, and grooming for all ages',
            'price' => 800.00,
            'duration' => '1-3 hours',
            'status' => 'active'
        ]);

        // Spa Services
        Service::create([
            'category_id' => $personalCare->id,
            'subcategory_id' => $spaServices->id,
            'name' => 'Spa Services – Massage, mani-pedi',
            'description' => 'Professional spa services including massage therapy and pedicure',
            'price' => 1200.00,
            'duration' => '1-2 hours',
            'status' => 'active'
        ]);

        // Home Maintenance Subcategories & Services
        $windowTreatments = Subcategory::create([
            'category_id' => $homeMaintenance->id,
            'name' => 'Window Treatments',
            'description' => 'Curtain and blind installation and repair services',
            'status' => 'active'
        ]);

        $paintingDecor = Subcategory::create([
            'category_id' => $homeMaintenance->id,
            'name' => 'Painting & Decoration',
            'description' => 'Interior painting and decorative services',
            'status' => 'active'
        ]);

        $carpentry = Subcategory::create([
            'category_id' => $homeMaintenance->id,
            'name' => 'Carpentry Services',
            'description' => 'Woodworking and furniture repair services',
            'status' => 'active'
        ]);

        $applianceMaintenance = Subcategory::create([
            'category_id' => $homeMaintenance->id,
            'name' => 'Appliance Maintenance',
            'description' => 'Home appliance repair and maintenance services',
            'status' => 'active'
        ]);

        $landscaping = Subcategory::create([
            'category_id' => $homeMaintenance->id,
            'name' => 'Landscape Maintenance',
            'description' => 'Garden and outdoor space maintenance',
            'status' => 'active'
        ]);

        // Window Treatments Services
        Service::create([
            'category_id' => $homeMaintenance->id,
            'subcategory_id' => $windowTreatments->id,
            'name' => 'Curtains & Blinds – Installation & repair',
            'description' => 'Professional installation and repair of curtains and blinds',
            'price' => 1000.00,
            'duration' => '2-4 hours',
            'status' => 'active'
        ]);

        // Painting & Decoration Services
        Service::create([
            'category_id' => $homeMaintenance->id,
            'subcategory_id' => $paintingDecor->id,
            'name' => 'Painting Services',
            'description' => 'Professional interior and exterior painting services',
            'price' => 2500.00,
            'duration' => 'Full day',
            'status' => 'active'
        ]);

        // Carpentry Services
        Service::create([
            'category_id' => $homeMaintenance->id,
            'subcategory_id' => $carpentry->id,
            'name' => 'Carpentry & Furniture Repair',
            'description' => 'Woodworking and furniture repair and restoration services',
            'price' => 1200.00,
            'duration' => '2-6 hours',
            'status' => 'active'
        ]);

        // Appliance Maintenance Services
        Service::create([
            'category_id' => $homeMaintenance->id,
            'subcategory_id' => $applianceMaintenance->id,
            'name' => 'Home Appliance Maintenance – AC, fridge, washing machine',
            'description' => 'Maintenance and repair services for AC, refrigerator, and washing machine',
            'price' => 600.00,
            'duration' => '1-3 hours',
            'status' => 'active'
        ]);

        // Landscape Maintenance Services
        Service::create([
            'category_id' => $homeMaintenance->id,
            'subcategory_id' => $landscaping->id,
            'name' => 'Landscape Maintenance',
            'description' => 'Garden and outdoor space maintenance and landscaping',
            'price' => 800.00,
            'duration' => '2-4 hours',
            'status' => 'active'
        ]);

        // Vehicle & Legal Services Subcategories & Services
        $vehicleServices = Subcategory::create([
            'category_id' => $vehicleLegal->id,
            'name' => 'Vehicle Services',
            'description' => 'Vehicle maintenance and recovery services',
            'status' => 'active'
        ]);

        $legalServices = Subcategory::create([
            'category_id' => $vehicleLegal->id,
            'name' => 'Legal Services',
            'description' => 'Legal assistance and renewal services',
            'status' => 'active'
        ]);

        // Vehicle Services
        Service::create([
            'category_id' => $vehicleLegal->id,
            'subcategory_id' => $vehicleServices->id,
            'name' => 'Vehicle Recovery',
            'description' => 'Professional vehicle recovery and towing services',
            'price' => 2000.00,
            'duration' => 'Variable',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $vehicleLegal->id,
            'subcategory_id' => $vehicleServices->id,
            'name' => 'Vehicle Renewal Services',
            'description' => 'Help with vehicle registration renewal and documentation',
            'price' => 1500.00,
            'duration' => '1-2 days',
            'status' => 'active'
        ]);

        Service::create([
            'category_id' => $vehicleLegal->id,
            'subcategory_id' => $vehicleServices->id,
            'name' => 'Bicycle Maintenance',
            'description' => 'Bicycle repair and maintenance services',
            'price' => 400.00,
            'duration' => '1-2 hours',
            'status' => 'active'
        ]);

        // Legal Services
        Service::create([
            'category_id' => $vehicleLegal->id,
            'subcategory_id' => $legalServices->id,
            'name' => 'Family Visa Renewal Services',
            'description' => 'Assistance with family visa renewal and documentation',
            'price' => 3000.00,
            'duration' => '1-2 weeks',
            'status' => 'active'
        ]);

        // Lifestyle & Events Subcategories & Services
        $eventPlanning = Subcategory::create([
            'category_id' => $lifestyleEvents->id,
            'name' => 'Event Planning',
            'description' => 'Party and event organization services',
            'status' => 'active'
        ]);

        $petCare = Subcategory::create([
            'category_id' => $lifestyleEvents->id,
            'name' => 'Pet Care Services',
            'description' => 'Pet care, grooming, and wellness services',
            'status' => 'active'
        ]);

        // Event Planning Services
        Service::create([
            'category_id' => $lifestyleEvents->id,
            'subcategory_id' => $eventPlanning->id,
            'name' => 'Party Organizer',
            'description' => 'Complete party planning and organization services',
            'price' => 5000.00,
            'duration' => 'Event-based',
            'status' => 'active'
        ]);

        // Pet Care Services
        Service::create([
            'category_id' => $lifestyleEvents->id,
            'subcategory_id' => $petCare->id,
            'name' => 'Pet Care & Grooming – Bathing, nail trimming, brushing',
            'description' => 'Complete pet care including bathing, nail trimming, and grooming services',
            'price' => 600.00,
            'duration' => '1-2 hours',
            'status' => 'active'
        ]);
    }
}
