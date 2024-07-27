<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::resource('/services', ServiceController::class);
// Route::resource('/bookings', BookingController::class);
// Route::post('/get-snap-token', [OrderController::class, 'getSnapToken']);
// Route::middleware('auth:sanctum')->group(function () {
// });

Route::middleware('api')->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    Route::get('/package', [PackageController::class, 'index']);
    Route::post('/package', [PackageController::class, 'store']);
    Route::get('/package/{package}', [PackageController::class, 'show']);
    Route::put('/package/{package}', [PackageController::class, 'update']);
    Route::delete('/package/{package}', [PackageController::class, 'destroy']);

    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::put('/bookings/{booking}', [BookingController::class, 'update']);
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);

    Route::get('/export-payments', [OrderController::class, 'exportPayments']);
    Route::post('/payment', [OrderController::class, 'createPayment']);
    Route::post('/payment/callback', [OrderController::class, 'paymentCallback']);
});
