<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin-dashboard');
    })->name('dashboard');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Products CRUD (explicit routes)
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('products/generate-slug', [ProductController::class, 'generateSlug'])->name('products.generate-slug');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
