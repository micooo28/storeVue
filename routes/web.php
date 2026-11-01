<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});



Route::get('/here', function () {
    return Inertia::render('Here');
})->name('here');

Route::get('/customerlist', function () {
    return Inertia::render('customer/Customertable');
})->name('customerlist');

Route::get('/order', function () {
    return Inertia::render('customer/Customersorder');
})->name('customer.orders');


require __DIR__.'/settings.php';
