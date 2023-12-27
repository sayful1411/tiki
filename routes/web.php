<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('frontend.home');
Route::get('/booking/bus/search', SearchController::class)->name('frontend.search');
Route::get('/booking/bus/{trip}', [BookingController::class, 'showSeats'])->name('show.seats');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/book/seats/{trip}', [BookingController::class, 'bookSeats'])->name('book.seats');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('login-form', function(){
    return view('frontend.login');
});
Route::get('register-form', function(){
    return view('frontend.register');
});

require __DIR__.'/auth.php';
