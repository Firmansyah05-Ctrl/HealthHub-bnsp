<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopRequestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\ShopRequestController as AdminShopRequestController;
use Illuminate\Support\Facades\Route;

// Redirect root to products page
Route::redirect('/', '/products');

// Public routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Cart routes (require authentication)
Route::middleware('auth')->prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
});

// Dashboard user
Route::get('/dashboard', [OrderController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Cancel order
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])
    ->middleware('auth')
    ->name('orders.cancel');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Protected routes (require authentication)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('orders.success');
    
    Route::get('/orders/{order}/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/orders/{order}/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/orders/{order}/feedback/show', [FeedbackController::class, 'show'])->name('feedback.show');

    // Report routes
    Route::get('/invoice/{order}', [ReportController::class, 'generateInvoice'])->name('report.invoice');

    Route::resource('shop-requests', ShopRequestController::class)
        ->only(['index', 'create', 'store']);


});



Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Halaman dashboard admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Kelola user
        Route::resource('users', UserController::class);

        // Kelola kategori
        Route::resource('categories', AdminCategoryController::class);

        // Kelola produk
        Route::resource('products', AdminProductController::class);
        
        // Kelola stok produk
        Route::get('/products-stock', [AdminProductController::class, 'stock'])->name('products.stock');
        Route::patch('/products/{product}/update-stock', [AdminProductController::class, 'updateStock'])->name('products.update-stock');

        // Kelola pesanan
        Route::resource('orders', AdminOrderController::class)->only([
            'index', 'update'
        ]);

        // Kelola feedback
        Route::resource('feedbacks', AdminFeedbackController::class)->only([
            'index', 'show', 'destroy'
        ]);

        // Shop Requests
        Route::get('/shop-requests', [AdminShopRequestController::class, 'index'])->name('shop_requests.index');
        Route::post('/shop-requests/{id}/approve', [AdminShopRequestController::class, 'approve'])->name('shop_requests.approve');
        Route::post('/shop-requests/{id}/reject', [AdminShopRequestController::class, 'reject'])->name('shop_requests.reject');
    });
        

// Breeze Auth routes (keep this at the bottom)
require __DIR__.'/auth.php';