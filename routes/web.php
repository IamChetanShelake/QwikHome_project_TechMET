<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
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
        Route::get('{service}/edit', [ServiceController::class, 'servicesEdit'])->name('services.services.edit');
        Route::put('{service}', [ServiceController::class, 'servicesUpdate'])->name('services.services.update');
        Route::delete('{service}', [ServiceController::class, 'servicesDestroy'])->name('services.services.destroy');
    });

    //service management old-------------
    Route::get('/services1', [ServiceController::class, 'index'])->name('services');
    Route::post('/customers/toggle-block', [CustomerController::class, 'toggleBlock'])
        ->name('customers.toggle-block');
    Route::get('/admin/search-users', [CustomerController::class, 'search']);
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
