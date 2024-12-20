<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BikeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TopupController;
use App\Http\Controllers\Api\RentalController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\MachineLogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Routes with Middleware
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/user/registerAdmin', [UserController::class, 'registerAdmin']);
    Route::post('/user/registerUser', [UserController::class, 'registerUser']);
    Route::get('/user/user_token', [UserController::class, 'user_token']);
    Route::get('/user/list', [UserController::class, 'list']);
});
Route::post('/login', [UserController::class, 'login']);

// Wallet Routes with Middleware
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/wallets/{id}', [WalletController::class, 'show']);
    Route::put('/wallets/{id}', [WalletController::class, 'update']);
});

// Topup Routes with Middleware
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/topups', [TopupController::class, 'index']);
    Route::post('/topups', [TopupController::class, 'store']);
});

// Station Routes (Admin Only)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/stations', [StationController::class, 'index']);
    Route::get('/stations/{id}', [StationController::class, 'show']);
    Route::post('/stations', [StationController::class, 'store']);
    Route::put('/stations/{id}', [StationController::class, 'update']);
    Route::delete('/stations/{id}', [StationController::class, 'destroy']);
});

// Bike Routes (Admin Only)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/bikes', [BikeController::class, 'index']);
    Route::get('/bikes/{id}', [BikeController::class, 'show']);
    Route::post('/bikes', [BikeController::class, 'store']);
    Route::put('/bikes/{id}', [BikeController::class, 'update']);
    Route::delete('/bikes/{id}', [BikeController::class, 'destroy']);
});

// Rental Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/rentals', [RentalController::class, 'index']);
    Route::post('/rentals/start', [RentalController::class, 'startRental']);
    Route::post('/rentals/end/{id}', [RentalController::class, 'endRental']);
});

// Payment Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/payments', [PaymentController::class, 'create']);
});

// Machine Log Routes (Admin Only)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/machine_logs', [MachineLogController::class, 'index']);
    Route::get('/machine_logs/{id}', [MachineLogController::class, 'show']);
});
