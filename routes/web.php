<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Auth::routes();

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/place-order', [CartController::class, 'place_order'])->name('cart.place.order');
Route::get('/order-confirmation', [CartController::class, 'confirmation'])->name('cart.confirmation');


// Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name("shop.product.details");

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
    Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
    Route::put('/cart/decrease-quantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
    Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
    Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');
    Route::get('/account-orders', [UserController::class, 'account_orders'])->name('user.account.orders');
    Route::get('/account-order-detials/{order_id}', [UserController::class, 'account_order_details'])->name('user.acccount.order.details');
    Route::put('/account-order/cancel-order', [UserController::class, 'account_cancel_order'])->name('user.account_cancel_order');
});

// Routes for Admin with Middleware
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brand/add', [AdminController::class, 'add_brand'])->name('admin.brand.add');
    Route::post('/admin/brand/store', [AdminController::class, 'add_brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'update_brand'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'delete_brand'])->name('admin.brand.delete');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'add_category_store'])->name('admin.category.store');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'delete_category'])->name('admin.category.delete');
    Route::get('/admin/product/add', [AdminController::class, 'add_product'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/{id}/edit', [AdminController::class, 'edit_product'])->name('admin.product.edit');
    Route::put('/admin/product/update', [AdminController::class, 'update_product'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete', [AdminController::class, 'delete_product'])->name('admin.product.delete');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/items/{order_id}', [AdminController::class, 'order_items'])->name('admin.order.items');
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');
});
