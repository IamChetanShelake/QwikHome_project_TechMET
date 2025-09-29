<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Panel Routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
