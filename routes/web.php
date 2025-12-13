<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', [UserController::class, 'home'])->name('index');

Route::get('/product_details/{id}', [UserController::class, 'productDetails'])->name('productdetails');

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/add_to_cart/{id}', [UserController::class, 'addToCart'])->middleware(['auth', 'verified'])->name('add_to_cart');

Route::get('/view_cart/{id}', [UserController::class, 'viewCart'])->middleware(['auth', 'verified'])->name('viewcart');

Route::delete('remove_cart_product/{id}', [UserController::class, 'removeCartproduct'])->middleware(['auth', 'verified'])->name('removecartproduct');

Route::get('/confirm_order', [UserController::class, 'confirmOrder'])->middleware(['auth', 'verified'])->name('confirm_order');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'index'])->name('admin.dashboard');
    Route::get('/add_category', [AdminController::class, 'addCategory'])->name('admin.addcategory');

    Route::post('/add_category', [AdminController::class, 'postAddCategory'])->name('admin.postaddcategory');

    Route::get('/view_category', [AdminController::class, 'viewCategory'])->name('admin.viewcategory');

    Route::get('/delete_category/{id}', [AdminController::class, 'deleteCategory'])->name('admin.deletecategory');

    Route::get('/update_category/{id}', [AdminController::class, 'updateCategory'])->name('admin.updatecategory');

    Route::post('/update_category/{id}', [AdminController::class, 'postupdateCategory'])->name('admin.postupdatecategory');

// Product Routes
      Route::get('/add_product', [AdminController::class, 'addProduct'])->name('admin.addproduct');

    Route::post('/add_product', [AdminController::class, 'postAddProduct'])->name('admin.postaddproduct');

    Route::get('/view_product', [AdminController::class, 'viewProduct'])->name('admin.viewproduct');

    Route::get('/delete_product/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteproduct');

    Route::get('/update_product/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateproduct');

    Route::post('/update_product/{id}', [AdminController::class, 'postUpdateProduct'])->name('admin.postupdateproduct');

    Route::post('/search', [AdminController::class, 'searchProduct'])->name('admin.searchproduct');

// End of Product Routes
});


require __DIR__.'/auth.php';

