<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\Admin\VehicleLimitController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Purchase flow
    Route::get('/purchase', [PurchaseController::class, 'selectFuel'])->name('purchase.select-fuel');
    Route::post('/purchase/vehicle-info', [PurchaseController::class, 'vehicleInfo'])->name('purchase.vehicle-info');
    Route::post('/purchase/confirm', [PurchaseController::class, 'confirm'])->name('purchase.confirm');
    Route::post('/purchase/process', [PurchaseController::class, 'process'])->name('purchase.process');
    Route::get('/purchase/{purchase}/slip', [PurchaseController::class, 'slip'])->name('purchase.slip');
    Route::get('/purchase/{purchase}/download', [PurchaseController::class, 'downloadSlip'])->name('purchase.download-slip');
    Route::get('/purchase/history', [PurchaseController::class, 'history'])->name('purchase.history');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Purchases
    Route::get('/purchases', [AdminPurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/{purchase}', [AdminPurchaseController::class, 'show'])->name('purchases.show');
    Route::patch('/purchases/{purchase}/collect', [AdminPurchaseController::class, 'markCollected'])->name('purchases.collect');
    Route::post('/purchases/collect-by-slip', [AdminPurchaseController::class, 'collectBySlipId'])->name('purchases.collect-by-slip');

    // Vehicle Limits
    Route::get('/vehicle-limits', [VehicleLimitController::class, 'index'])->name('vehicle-limits.index');
    Route::get('/vehicle-limits/create', [VehicleLimitController::class, 'create'])->name('vehicle-limits.create');
    Route::post('/vehicle-limits', [VehicleLimitController::class, 'store'])->name('vehicle-limits.store');
    Route::get('/vehicle-limits/{vehicleLimit}/edit', [VehicleLimitController::class, 'edit'])->name('vehicle-limits.edit');
    Route::put('/vehicle-limits/{vehicleLimit}', [VehicleLimitController::class, 'update'])->name('vehicle-limits.update');
    Route::delete('/vehicle-limits/{vehicleLimit}', [VehicleLimitController::class, 'destroy'])->name('vehicle-limits.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
