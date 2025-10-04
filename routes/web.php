<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\faqController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Vendor\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\isAdmin;

Route::get('/', function () {
    return view('welcome');
});

// Admin Panel Routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::middleware(['auth', isAdmin::class])->group(function () {
    // Add more admin routes here that require authentication
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    //customer management-------------
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customer-view/{id}', [CustomerController::class, 'view'])->name('customer.view');

    //service management-------------
    Route::prefix('services')->group(function () {
        // Categories
        Route::get('categories', [ServiceController::class, 'categoriesIndex'])->name('services.categories.index');
        Route::get('categories/create', [ServiceController::class, 'categoriesCreate'])->name('services.categories.create');
        Route::post('categories', [ServiceController::class, 'categoriesStore'])->name('services.categories.store');
        Route::get('categories/{category}/edit', [ServiceController::class, 'categoriesEdit'])->name('services.categories.edit');
        Route::put('categories/{category}', [ServiceController::class, 'categoriesUpdate'])->name('services.categories.update');
        Route::delete('categories/{category}', [ServiceController::class, 'categoriesDestroy'])->name('services.categories.destroy');

        // Subcategories
        Route::get('subcategories', [ServiceController::class, 'subcategoriesIndex'])->name('services.subcategories.index');
        Route::get('subcategories/create', [ServiceController::class, 'subcategoriesCreate'])->name('services.subcategories.create');
        Route::post('subcategories', [ServiceController::class, 'subcategoriesStore'])->name('services.subcategories.store');
        Route::get('subcategories/{subcategory}/edit', [ServiceController::class, 'subcategoriesEdit'])->name('services.subcategories.edit');
        Route::put('subcategories/{subcategory}', [ServiceController::class, 'subcategoriesUpdate'])->name('services.subcategories.update');
        Route::delete('subcategories/{subcategory}', [ServiceController::class, 'subcategoriesDestroy'])->name('services.subcategories.destroy');

        // Services
        Route::get('', [ServiceController::class, 'servicesIndex'])->name('services.services.index');
        Route::get('create', [ServiceController::class, 'servicesCreate'])->name('services.services.create');
        Route::post('', [ServiceController::class, 'servicesStore'])->name('services.services.store');
        Route::get('{service}', [ServiceController::class, 'servicesShow'])->name('services.services.show');
        Route::get('{service}/edit', [ServiceController::class, 'servicesEdit'])->name('services.services.edit');
        Route::put('{service}', [ServiceController::class, 'servicesUpdate'])->name('services.services.update');
        Route::delete('{service}', [ServiceController::class, 'servicesDestroy'])->name('services.services.destroy');
    });

    //service management old-------------
    Route::get('/services1', [ServiceController::class, 'index'])->name('services');
    Route::post('/customers/toggle-block', [CustomerController::class, 'toggleBlock'])
        ->name('customers.toggle-block');
    Route::get('/admin/search-users', [CustomerController::class, 'search']);

    //FAQ management-------------
    Route::get('/faqs', [faqController::class, 'index'])->name('faq');
    Route::get('/faq-create', [faqController::class, 'create'])->name('faq.create');
    Route::post('/faq-store', [faqController::class, 'store'])->name('faq.store');
    Route::get('/faq-edit/{id}', [faqController::class, 'edit'])->name('faq.edit');
    Route::put('/faq-update/{id}', [faqController::class, 'update'])->name('faq.update');
    Route::get('/faq-view/{id}', [faqController::class, 'view'])->name('faq.view');
    Route::delete('/faq-delete/{id}', [faqController::class, 'delete'])->name('faq.delete');

    //Coupons management-------------
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{id}', [CouponController::class, 'view'])->name('coupons.view');
    Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{id}', [CouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [CouponController::class, 'delete'])->name('coupons.delete');

    //Promocodes management-------------
    Route::get('/promocodes', [PromocodeController::class, 'index'])->name('promocodes.index');
    Route::get('/promocodes/create', [PromocodeController::class, 'create'])->name('promocodes.create');
    Route::post('/promocodes', [PromocodeController::class, 'store'])->name('promocodes.store');
    Route::get('/promocodes/{id}', [PromocodeController::class, 'view'])->name('promocodes.view');
    Route::get('/promocodes/{id}/edit', [PromocodeController::class, 'edit'])->name('promocodes.edit');
    Route::put('/promocodes/{id}', [PromocodeController::class, 'update'])->name('promocodes.update');
    Route::delete('/promocodes/{id}', [PromocodeController::class, 'delete'])->name('promocodes.delete');

    //FAQ Ajax endpoints-------------
    Route::get('/faqs/get-subcategories/{categoryId}', [faqController::class, 'getSubcategories'])->name('faqs.getSubcategories');
    Route::get('/faqs/get-services/{categoryId}/{subcategoryId?}', [faqController::class, 'getServices'])->name('faqs.getServices');

    //Complaints management-------------
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{id}', [ComplaintController::class, 'view'])->name('complaints.view');
    Route::post('/complaints/{id}/assign-admin', [ComplaintController::class, 'assignAdmin'])->name('complaints.assignAdmin');
    Route::post('/complaints/{id}/update-status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
    Route::post('/complaints/{id}/resolve', [ComplaintController::class, 'resolveComplaint'])->name('complaints.resolveComplaint');
    Route::post('/complaints/{id}/update-notes', [ComplaintController::class, 'updateNotes'])->name('complaints.updateNotes');
    Route::get('/complaints-stats', [ComplaintController::class, 'getStats'])->name('complaints.stats');

    //Service Providers management-------------
    Route::resource('serviceProviders', ServiceProviderController::class);

    //Vendor Bookings management-------------
    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    });

    //Vendor management-------------
    Route::resource('vendors', \App\Http\Controllers\Admin\VendorController::class)->names([
        'index' => 'admin.vendors.index',
        'create' => 'admin.vendors.create',
        'store' => 'admin.vendors.store',
        'show' => 'admin.vendors.show',
        'edit' => 'admin.vendors.edit',
        'update' => 'admin.vendors.update',
        'destroy' => 'admin.vendors.destroy',
    ]);

    //Analytics management-------------
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index');

    //Profile management-------------
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload.image');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/clean-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('event:cache');
    $exitCode = Artisan::call('event:clear');
    $exitCode = Artisan::call('optimize');
    return '<h1>Cache facade value cleared</h1>';
});
