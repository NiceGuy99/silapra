<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
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
    Route::get('/admin/accepted-requests', [AdminController::class, 'acceptedRequests'])->name('admin.accepted_requests');
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
    Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
});

require __DIR__.'/auth.php';
