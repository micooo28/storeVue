<?php
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerRegistrationController;
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

Route::post('/customer/orders', [OrderController::class, 'store'])
    ->name('orders.store');

Route::get('/customer/register', function () {
    return Inertia::render('customer/Customerregistration');
})->name('customer.register');

Route::post('/customer/register/submit', [CustomerRegistrationController::class, 'store'])
    ->name('customer.register.submit');

require __DIR__.'/settings.php';
