<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest access)
|--------------------------------------------------------------------------
*/

Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/contact', [UserController::class, 'contact'])->name('contact');
Route::get('/product_details/{id}', [UserController::class, 'productDetails'])->name('product.details');
Route::get('/category/{id}/products', [UserController::class, 'categoryProducts'])->name('category.products');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-validate', [UserController::class, 'validateForm'])->name('register.validate');

/*
|--------------------------------------------------------------------------
| User Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Cart Operations
    Route::get('/view_cart', [OrderController::class, 'viewCart'])->name('cart.index');
    Route::post('/add_to_cart/{id}', [OrderController::class, 'addToCart'])->name('add_to_cart');
    Route::post('/confirm_order', [OrderController::class, 'confirmOrder'])->name('order.confirm');
    Route::get('/checkout/review', [OrderController::class, 'reviewOrder'])->name('order.review');
    Route::post('/checkout/finalize', [OrderController::class, 'finalizeOrder'])->name('order.finalize');

    // JS/AJAX Cart Updates
    Route::post('/cart/update/{id}', [OrderController::class, 'updateQuantity'])->name('cart.js.update');
    Route::delete('/cart/remove/{id}', [OrderController::class, 'removeCartproduct'])->name('cart.js.remove');

    // Success/Payment Page for Users
    Route::get('/payment/success/{order}/{method}', [OrderController::class, 'paymentProcess'])->name('payment.success');

});

/*
|--------------------------------------------------------------------------
| Admin Routes (Restricted to Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Category Management
    Route::controller(AdminController::class)->group(function () {
        Route::get('/categories', 'viewCategory')->name('categories.index');
        Route::get('/categories/create', 'addCategory')->name('categories.create');
        Route::post('/categories', 'postAddCategory')->name('categories.store');
        Route::get('/categories/{id}/edit', 'updateCategory')->name('categories.edit');
        Route::post('/categories/{id}', 'postupdateCategory')->name('categories.update');
        Route::delete('/categories/{id}', 'deleteCategory')->name('categories.delete');

        // Product Management
        Route::get('/products', 'viewProduct')->name('products.index');
        Route::get('/products/create', 'addProduct')->name('products.create');
        Route::post('/products', 'postAddProduct')->name('products.store');
        Route::get('/products/{id}/edit', 'updateProduct')->name('products.edit');
        Route::put('/products/{id}', 'postUpdateProduct')->name('products.update');
        Route::delete('/products/{id}', 'deleteProduct')->name('products.delete');

        // Order Management
        Route::get('/orders', 'viewOrders')->name('orders.index');
        Route::post('/orders/{id}/status', 'updateOrderStatus')->name('orders.updateStatus');
        Route::post('/orders/{id}/confirm-payment', 'confirmPayment')->name('order.confirm-payment');
        Route::post('/orders/{id}/cancel', 'cancelOrder')->name('orders.cancel');
        Route::post('/orders/{id}/toggle-payment', 'togglePaymentStatus')->name('orders.togglePayment');
        Route::put('/orders/{id}/edit-items', 'editOrderItems')->name('order.editItems');
    });

    // Admin-specific Payment Process (if needed)
    Route::get('/payment/process/{order}/{method}', [OrderController::class, 'paymentProcess'])->name('payment.process');
});
