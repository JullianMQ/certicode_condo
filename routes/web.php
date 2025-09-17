<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Dashboard route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Placeholder routes for sidebar navigation (to be implemented later)
Route::get('/residents', function () {
    return view('coming-soon', ['title' => 'Residents Management']);
})->name('residents.index');

Route::get('/condos', function () {
    return view('coming-soon', ['title' => 'Condo Units']);
})->name('condos.index');

Route::get('/bookings', function () {
    return view('coming-soon', ['title' => 'Bookings Management']);
})->name('bookings.index');

Route::get('/amenities', function () {
    return view('coming-soon', ['title' => 'Amenities']);
})->name('amenities.index');

Route::get('/maintenance', function () {
    return view('coming-soon', ['title' => 'Maintenance Requests']);
})->name('maintenance.index');

Route::get('/payments', function () {
    return view('coming-soon', ['title' => 'Payments']);
})->name('payments.index');
