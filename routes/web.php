<?php

use App\Http\Controllers\CustomerFullListController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerRegistrationController;
use App\Http\Controllers\CustomerTableController;
use App\Http\Controllers\EmploymentController;
use App\Models\CustomerInfo;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

// Posting the customer orders/items
Route::post('/customer/orders', [OrderController::class, 'store'])
    ->name('orders.store');

Route::get('/orders', [OrderController::class, 'index'])
    ->name('customer.order');

//   Fetching for Customer Table
Route::get('/customerlist', [CustomerTableController::class,'index', EmploymentController::class, 'index'])
    ->name('table');

Route::get('/employeeList', [CustomerFullListController::class,'index'])
    ->name('fullList');


    
//----------------Routing-Pages----------------------------------->


//For Registration of Employees
Route::get('/customer/register', function () {
    return Inertia::render('customer/Customerregistration');
})->name('customer.register');

//Customer Table Summary Page
// Route::get('/customerlist', function () {
//     return Inertia::render('customer/Customertable');
// })->name('customerlist');

//Main Dashboard of Admin
Route::get('/here', function () {
    return Inertia::render('Here');
})->name('here');

//===================Posting-Routes==========================>

//Posting the New Employees Details
Route::post('/customer/register/submit', [CustomerRegistrationController::class, 'store'])
    ->name('customer.register.submit');

require __DIR__.'/settings.php';
