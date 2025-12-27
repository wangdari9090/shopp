<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserDashboardController;

// Route::get('/', function () {
//     return 'OK';
// });


Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/contact', [UserController::class, 'contact'])->name('contact');
Route::get('/product_details/{id}', [UserController::class, 'productDetails'])->name('product.details');
Route::get('/category/{id}/products', [UserController::class, 'categoryProducts'])->name('category.products');
    
/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| User Routes (Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->name('user.dashboard');

    Route::post('/add_to_cart/{id}', [UserController::class, 'addToCart'])
        ->name('add_to_cart');

    Route::get('/view_cart', [UserController::class, 'viewCart'])
        ->name('cart.view');

    Route::delete('/remove_cart_product/{id}', [UserController::class, 'removeCartproduct'])
        ->name('cart.remove');

    Route::post('/confirm_order', [UserController::class, 'confirmOrder'])
        ->name('order.confirm');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Category
    Route::get('/categories', [AdminController::class, 'viewCategory'])
        ->name('categories.index');

    Route::get('/categories/create', [AdminController::class, 'addCategory'])
        ->name('categories.create');

    Route::post('/categories', [AdminController::class, 'postAddCategory'])
        ->name('categories.store');

    Route::get('/categories/{id}/edit', [AdminController::class, 'updateCategory'])
        ->name('categories.edit');

    Route::post('/categories/{id}', [AdminController::class, 'postupdateCategory'])
        ->name('categories.update');

    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])
        ->name('categories.delete');

    // Products
    Route::get('/products', [AdminController::class, 'viewProduct'])
        ->name('products.index');

    Route::get('/products/create', [AdminController::class, 'addProduct'])
        ->name('products.create');

    Route::post('/products', [AdminController::class, 'postAddProduct'])
        ->name('products.store');

    Route::get('/products/{id}/edit', [AdminController::class, 'updateProduct'])
        ->name('products.edit');

    Route::post('/products/{id}', [AdminController::class, 'postUpdateProduct'])
        ->name('products.update');

    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])
        ->name('products.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'viewOrders'])
        ->name('orders.index');

    Route::patch('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])
        ->name('orders.updateStatus');
});
