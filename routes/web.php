<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard route that redirects based on role
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin' || auth()->user()->role === 'petugas') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('orders.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin and Petugas routes
Route::middleware(['auth', 'verified', 'role:admin,petugas'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/completed-orders', [AdminController::class, 'completedOrders'])->name('admin.completed-orders');
    Route::get('/admin/accepted-orders', [AdminController::class, 'acceptedOrders'])->name('admin.accepted-orders');

    // Officer management routes (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::resource('officers', OfficerController::class)->except(['show', 'create', 'edit']);
        Route::patch('/officers/{officer}/toggle-status', [OfficerController::class, 'toggleStatus'])->name('officers.toggle-status');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('/orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
});

require __DIR__.'/auth.php';
