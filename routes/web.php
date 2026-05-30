<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\faqController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\PromocodeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceOffersController;
use App\Http\Controllers\Vendor\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\isAdmin;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\ContentManagement\BannerController;
use App\Http\Controllers\Admin\ContentManagement\OfferController;
use App\Http\Controllers\Admin\ContentManagement\CampaignController;
use App\Http\Controllers\Admin\ContentManagement\DisclaimerController;
use App\Http\Controllers\Admin\ContentManagement\PrivacyPolicyController;
use App\Http\Controllers\Admin\ContentManagement\RefundPolicyController;
use App\Http\Controllers\Admin\ContentManagement\TermsConditionController;
use App\Http\Controllers\Admin\PushNotificationController;
use App\Models\Disclaimer;
use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use App\Models\RefundPolicy;
use App\Models\Service;
use App\Models\ServiceOffer;
use App\Models\Subcategory;
use App\Http\Controllers\Admin\ProfileChangeRequestController;
use App\Http\Controllers\Admin\ServiceProviderFaqController;
use Illuminate\Http\Request;
use App\Http\Controllers\api\AuthApiController;


use App\Http\Controllers\Website\HomeController as WebsiteHomeController;




//live time od Dubai 
Route::get('/time', function () {
    return "
    <html>
        <head>
            <title>Live Dubai Time</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    margin-top: 20%;
                    background: #0a0a0a;
                    color: #00ffcc;
                }
                h1 {
                    font-size: 2rem;
                }
                #time {
                    font-size: 3rem;
                    font-weight: bold;
                    letter-spacing: 2px;
                }
            </style>
        </head>
        <body>
            <h1>Live Dubai Time</h1>
            <div id='time'></div>

            <script>
                function updateTime() {
                    const now = new Date();
                    // Convert to Dubai timezone
                    const dubaiTime = now.toLocaleString('en-US', { 
                        timeZone: 'Asia/Dubai', 
                        hour12: true 
                    });

                    // Get current milliseconds (simulating micro/nano part)
                    const ms = now.getMilliseconds().toString().padStart(3, '0');

                    // Combine time + milliseconds
                    document.getElementById('time').textContent = dubaiTime + '.' + ms;
                }

                // Update every 10 milliseconds
                setInterval(updateTime, 10);
                updateTime();
            </script>
        </body>
    </html>";
});
Route::get('/', function () {
    return view('auth.login');
});
// Policy routes
Route::get('/disclaimer', function () {
    $disclaimers = Disclaimer::all();
    return view('pages.disclaimer', compact('disclaimers'));
})->name('disclaimers');

Route::get('/privacy-policy', function () {
    $privacyPolicies = PrivacyPolicy::all();
    return view('pages.privacy-policy', compact('privacyPolicies'));
})->name('privacy.policy');

Route::get('/terms-conditions', function () {
    $termsConditions = TermsCondition::all();
    return view('pages.terms-conditions', compact('termsConditions'));
})->name('terms.conditions');

Route::get('/refund-policy', function () {
    $refundPolicies = RefundPolicy::all();
    return view('pages.refund-policy', compact('refundPolicies'));
})->name('refund.policy');

// Admin Panel Routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::middleware(['auth', isAdmin::class])->group(function () {


    // Add more admin routes here that require authentication
    Route::get('/admin', function () {
        $stats = [
            'total_bookings' => \App\Models\Booking::count(),
            'total_revenue' => \App\Models\Booking::sum('price'),
            'total_customers' => \App\Models\User::where('role', 'user')->count(),
            'total_providers' => \App\Models\User::where('role', 'serviceprovider')->count(),
            'total_services' => \App\Models\Service::count(),
            'total_coupons' => \App\Models\Coupon::count(),
            'total_vendors' => \App\Models\User::where('role', 'vendor')->count(),
            'total_complaints' => \App\Models\Complaint::count(),
            'recent_bookings' => \App\Models\Booking::with(['customer', 'service', 'serviceProvider'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
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
        Route::post('{service}/toggle/{field}', [ServiceController::class, 'toggleField'])->name('services.services.toggle');
        Route::get('{service}', [ServiceController::class, 'servicesShow'])->name('services.services.show');
        Route::get('{service}/edit', [ServiceController::class, 'servicesEdit'])->name('services.services.edit');
        Route::put('{service}', [ServiceController::class, 'servicesUpdate'])->name('services.services.update');
        Route::delete('{service}', [ServiceController::class, 'servicesDestroy'])->name('services.services.destroy');

        // Service Offers
        // Route::resource('offers', \App\Http\Controllers\Admin\ServiceOffersController::class)->parameters(['offers' => 'serviceOffer'])->except(['create', 'show'])->names([
        //     'index' => 'services.offers.index',
        //     'store' => 'services.offers.store',
        //     'update' => 'services.offers.update',
        //     'destroy' => 'services.offers.destroy',
        //     'edit' => 'services.offers.edit'
        // ]);
        Route::get('offers/index', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'index'])->name('offers.index');

        Route::get('offers/create/{service}', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'create'])->name('offers.create');
        // Route already defined by resource above
        Route::post('offers/store', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'store'])->name('offers.store');
        Route::get('offers/{serviceOffer}', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'show'])->name('offers.show');
        Route::get('offers/{serviceOffer}/edit', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'edit'])->name('offers.edit');
        Route::put('offers/{serviceOffer}/update', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'update'])->name('offers.update');
        Route::delete('offers/{serviceOffer}/delete', [\App\Http\Controllers\Admin\ServiceOffersController::class, 'destroy'])->name('offers.destroy');

    });

    //service management old-------------
    Route::get('/services1', [ServiceController::class, 'index'])->name('services');
    Route::post('/customers/toggle-block', [CustomerController::class, 'toggleBlock'])
        ->name('customers.toggle-block');
    Route::get('/admin/search-users', [CustomerController::class, 'search']);

    // Content Management routes grouped under /admin/content-management
    Route::prefix('content-management')->name('contentManagement.')->group(function () {
        // Banners management
        Route::resource('banners', BannerController::class)->names([
            'index' => 'banners.index',
            'create' => 'banners.create',
            'store' => 'banners.store',
            'show' => 'banners.show',
            'edit' => 'banners.edit',
            'update' => 'banners.update',
            'destroy' => 'banners.destroy',
        ]);

        // Offers management
        // Route::resource('offers', OfferController::class)->names([
        //     'index' => 'offers.index',
        //     'create' => 'offers.create',
        //     'store' => 'offers.store',
        //     'show' => 'offers.show',
        //     'edit' => 'offers.edit',
        //     'update' => 'offers.update',
        //     'destroy' => 'offers.destroy',
        // ]);

        // Campaigns management
        Route::resource('campaigns', CampaignController::class)->names([
            'index' => 'campaigns.index',
            'create' => 'campaigns.create',
            'store' => 'campaigns.store',
            'show' => 'campaigns.show',
            'edit' => 'campaigns.edit',
            'update' => 'campaigns.update',
            'destroy' => 'campaigns.destroy',
        ]);

        // Policy management routes
        Route::resource('disclaimers', DisclaimerController::class)->names([
            'index' => 'disclaimers.index',
            'create' => 'disclaimers.create',
            'store' => 'disclaimers.store',
            'show' => 'disclaimers.show',
            'edit' => 'disclaimers.edit',
            'update' => 'disclaimers.update',
            'destroy' => 'disclaimers.destroy',

            'disclaimers' => 'disclaimers',
        ]);

        Route::resource('privacy-policies', PrivacyPolicyController::class)->names([
            'index' => 'privacy-policies.index',
            'create' => 'privacy-policies.create',
            'store' => 'privacy-policies.store',
            'show' => 'privacy-policies.show',
            'edit' => 'privacy-policies.edit',
            'update' => 'privacy-policies.update',
            'destroy' => 'privacy-policies.destroy',

            'privacyPolicy' => 'privacyPolicy',
        ]);

        Route::resource('refund-policies', RefundPolicyController::class)->names([
            'index' => 'refund-policies.index',
            'create' => 'refund-policies.create',
            'store' => 'refund-policies.store',
            'show' => 'refund-policies.show',
            'edit' => 'refund-policies.edit',
            'update' => 'refund-policies.update',
            'destroy' => 'refund-policies.destroy',

            'refundPolicy' => 'refundPolicy',
        ]);

        Route::resource('terms-conditions', TermsConditionController::class)->names([
            'index' => 'terms-conditions.index',
            'create' => 'terms-conditions.create',
            'store' => 'terms-conditions.store',
            'show' => 'terms-conditions.show',
            'edit' => 'terms-conditions.edit',
            'update' => 'terms-conditions.update',
            'destroy' => 'terms-conditions.destroy',

            'terms_and_conditions' => 'terms_and_conditions',
        ]);
    });

    //FAQ management-------------
    Route::get('/faqs', [faqController::class, 'index'])->name('faq');
    Route::get('/faq-create', [faqController::class, 'create'])->name('faq.create');
    Route::post('/faq-store', [faqController::class, 'store'])->name('faq.store');
    Route::get('/faq-edit/{id}', [faqController::class, 'edit'])->name('faq.edit');
    Route::put('/faq-update/{id}', [faqController::class, 'update'])->name('faq.update');
    Route::get('/faq-view/{id}', [faqController::class, 'view'])->name('faq.view');
    Route::delete('/faq-delete/{id}', [faqController::class, 'delete'])->name('faq.delete');

    // FAQ grouped by Service
    Route::get('/faqs/service/{serviceId}', [faqController::class, 'viewByService'])->name('faqs.service.view');
    Route::get('/faqs/service/{serviceId}/edit', [faqController::class, 'editByService'])->name('faqs.service.edit');
    Route::put('/faqs/service/{serviceId}', [faqController::class, 'updateByService'])->name('faqs.service.update');

    //Coupons management-------------
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');

    // AJAX routes for coupons (must come before parameterized routes)
    Route::get('/coupons/get-subcategories/{categoryId}', [CouponController::class, 'getSubcategories'])->name('coupons.get-subcategories');
    Route::get('/coupons/get-services/{categoryId}/{subcategoryId?}', [CouponController::class, 'getServices'])->name('coupons.get-services');

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
    Route::get('/admin/search-service-providers', [ServiceProviderController::class, 'search'])->name('serviceProviders.search');

    //Vendor Bookings management-------------
    Route::prefix('vendor')->name('vendor.')->group(function () {
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::post('bookings/save-auto-cancel-setting', [BookingController::class, 'saveAutoCancelSetting'])->name('bookings.saveAutoCancelSetting');
        Route::post('bookings/cancel-old-bookings', [BookingController::class, 'cancelOldBookings'])->name('bookings.cancelOldBookings');
    });

    //Vendor management-------------
    Route::resource('vendors', VendorController::class)->names([
        'index' => 'admin.vendors.index',
        'create' => 'admin.vendors.create',
        'store' => 'admin.vendors.store',
        'show' => 'admin.vendors.show',
        'edit' => 'admin.vendors.edit',
        'update' => 'admin.vendors.update',
        'destroy' => 'admin.vendors.destroy',
    ]);
    
        //Profile Change Requests management-------------
//Profile Change Requests management-------------
    Route::get('/profile-change-requests', [ProfileChangeRequestController::class, 'index'])->name('admin.profile-change-requests.index');
    Route::get('/profile-change-requests/{id}', [ProfileChangeRequestController::class, 'show'])->name('admin.profile-change-requests.show');
    Route::post('/profile-change-requests/{id}/approve', [ProfileChangeRequestController::class, 'approve'])->name('admin.profile-change-requests.approve');
    Route::post('/profile-change-requests/{id}/reject', [ProfileChangeRequestController::class, 'reject'])->name('admin.profile-change-requests.reject');
    Route::post('/profile-change-requests/{id}/approve-field/{field}', [ProfileChangeRequestController::class, 'approveField'])->name('admin.profile-change-requests.approve-field');
    Route::post('/profile-change-requests/{id}/reject-field/{field}', [ProfileChangeRequestController::class, 'rejectField'])->name('admin.profile-change-requests.reject-field');
    Route::post('/profile-change-requests/{id}/approve-all', [ProfileChangeRequestController::class, 'approveAll'])->name('admin.profile-change-requests.approve-all');
    Route::post('/profile-change-requests/{id}/reject-all', [ProfileChangeRequestController::class, 'rejectAll'])->name('admin.profile-change-requests.reject-all');

    //Analytics management-------------
    Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index');

    //Profile management-------------
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-image', [ProfileController::class, 'uploadImage'])->name('profile.upload.image');
    Route::post('/get-pending-profile-change-requests', [ProfileController::class, 'getPendingProfileChangeRequests']);
    Route::post('/approve-profile-change-request', [ProfileController::class, 'approveProfileChangeRequest']);
    Route::post('/reject-profile-change-request', [ProfileController::class, 'rejectProfileChangeRequest']);

    //Feedback management-------------
    Route::get('/feedback', [\App\Http\Controllers\Admin\FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/search', [\App\Http\Controllers\Admin\FeedbackController::class, 'search'])->name('feedback.search');

    // Push Notifications management-------------
    Route::resource('push-notifications', PushNotificationController::class);
    
    
    
     // Service Provider FAQs management-------------
    Route::resource('service-provider-faqs', ServiceProviderFaqController::class);
    
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/clear', function () {

    $exitCode = Artisan::call('optimize:clear');
    return '<h1>all Cache cleared</h1>';
});
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

Route::get('/test-firebase-push', function () {
    try {
        \Log::info('Test Firebase Route: Starting test push notification');

        $firebase = new \App\Services\FirebaseService();

        $title = "QwikHom 🔔";
        $body = "Test notification from Laravel to Flutter device!";
        $token = "c8drvS6FRCC3rM-P_amBXB:APA91bG7A6HTb_X_P9kGQKtjC_jVR-3fk6m4vZF16MTd6fsn7t2ipzLUQ610Pbe230h-dfFzFO0b0k16brPkTGmfDSTe5lA2B_foli-Px0vzu-YQhjn2v4Y";

        \Log::info('Test Firebase Route: Sending notification', [
            'title' => $title,
            'body' => $body,
            'token_prefix' => substr($token, 0, 20) . '...'
        ]);

        $result = $firebase->sendPush($token, $title, $body);

        \Log::info('Test Firebase Route: Notification sent successfully', [
            'result' => $result
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully!',
            'data' => $result
        ]);
    } catch (\Exception $e) {
        \Log::error('Test Firebase Route: Failed to send notification', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to send notification: ' . $e->getMessage()
        ], 500);
    }
});



Route::get('/', [WebsiteHomeController::class, 'index'])->name('website.home');


Route::get('/demo', function () {
    return view('website.demo');
});


Route::get('/demo', function () {
    return view('website.demo');
});

Route::get('/login', function () {
    return view('website.login');
})->name('login');

Route::get('/cart', function () {
    $cart = session('website_cart', []);
    $ids = array_keys($cart);
    $cartServices = Service::whereIn('id', $ids)->get()->sortBy(function ($service) use ($ids) {
        return array_search($service->id, $ids);
    });
    $cartSubtotal = $cartServices->sum(function ($service) use ($cart) {
        $price = $service->price_onetime
            ?? $service->price_weekly
            ?? $service->price_monthly
            ?? $service->price_yearly
            ?? 0;

        return (float) $price * ($cart[$service->id] ?? 1);
    });
    $cartTax = $cartServices->isNotEmpty() ? 50 : 0;
    $cartTotal = $cartSubtotal + $cartTax;

    return view('website.cart', compact('cartServices', 'cart', 'cartSubtotal', 'cartTax', 'cartTotal'));
})->name('cart.page');

Route::post('/cart/add/{service}', function (Request $request, Service $service) {
    $cart = session('website_cart', []);
    $cart[$service->id] = ($cart[$service->id] ?? 0) + 1;
    session(['website_cart' => $cart]);

    return response()->json([
        'success' => true,
        'message' => 'Service added to cart',
        'cart_count' => array_sum($cart),
    ]);
})->name('cart.add');

Route::post('/cart/update/{service}', function (Request $request, Service $service) {
    $cart = session('website_cart', []);
    $quantity = max(1, (int) $request->input('quantity', 1));
    $cart[$service->id] = $quantity;
    session(['website_cart' => $cart]);

    return response()->json([
        'success' => true,
        'quantity' => $quantity,
        'cart_count' => array_sum($cart),
    ]);
})->name('cart.update');

Route::post('/cart/remove/{service}', function (Request $request, Service $service) {
    $cart = session('website_cart', []);
    unset($cart[$service->id]);
    session(['website_cart' => $cart]);

    return response()->json([
        'success' => true,
        'cart_count' => array_sum($cart),
    ]);
})->name('cart.remove');

Route::get('/wishlist', function () {
    $wishlist = session('website_wishlist', []);
    $ids = array_keys($wishlist);
    $wishlistServices = Service::whereIn('id', $ids)->get()->sortBy(function ($service) use ($ids) {
        return array_search($service->id, $ids);
    });

    return view('website.user.wishlist', compact('wishlistServices'));
})->name('wishlist.page');

Route::post('/wishlist/add/{service}', function (Request $request, Service $service) {
    $wishlist = session('website_wishlist', []);
    $wishlist[$service->id] = true;
    session(['website_wishlist' => $wishlist]);

    return response()->json([
        'success' => true,
        'message' => 'Service added to wishlist',
        'wishlist_count' => count($wishlist),
    ]);
})->name('wishlist.add');


Route::get('/iron', function () {
    return view('website.user.ironing');
});

// Route::get('/', function () {
//     return view('user.ironing2');
// });

//  Route::get('/', function () {
//      return view('user.booking');
//  });

//  Route::get('/', function () {
//       return view('user.booking2');
//   });

Route::get('/booking', function () {
    return view('website.user.mybooking');
})->name('booking.page');

// Route::get('/', function () {
//      return view('user.desktop');
//  });
// Route::get('/', function () {
//      return view('user.desktop2');
//  });
Route::get('/verification', function () {
    return view('website.verification');
})->name('verification');

Route::post('/verification', function () {
    return redirect('/');
});

Route::get('/signup', function () {
    return view('website.signup');
})->name('signup.page');

Route::post('/signup', function (Request $request) {
    $request->merge([
        'name' => trim($request->first_name . ' ' . $request->last_name),
    ]);

    $response = app(AuthApiController::class)->signup($request);

    if ($response->getStatusCode() === 201) {
        return redirect('/login');
    }

    return $response;
});

Route::get('/coreservices', function () {
    $subcategories = Subcategory::where('status', 'active')->latest()->get();

    return view('website.coreservices', compact('subcategories'));
})->name('coreservices.page');
