<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('/', action: [FrontendController::class,'Home'])->name('home');
Route::get('home', action: [FrontendController::class,'Home'])->name('home');
Route::get('about', action: [FrontendController::class,'About'])->name('about');
Route::get('contact', action: [FrontendController::class,'Contact'])->name('contact');
Route::get('cart', action: [FrontendController::class,'Cart'])->name('cart');
Route::get('private_Policy', action: [FrontendController::class,'Private_Policy'])->name('private_Policy');
Route::get('shipping_Policy', action: [FrontendController::class,'Shipping_policy'])->name('shipping_policy');
Route::get('terms-and-condition', action: [FrontendController::class,'Terms'])->name('terms');
Route::get('product', action: [FrontendController::class,'Product'])->name('product');
Route::get('wishlist', action: [FrontendController::class,'Wishlist'])->name('wishlist');
Route::get('Login', action: [FrontendController::class,'Login'])->name('login');
Route::get('signup', action: [FrontendController::class,'Signup'])->name('signup');
Route::get('checkout', action: [FrontendController::class,'Checkout'])->name('checkout');
Route::get('profile', action: [FrontendController::class,'Profile'])->name('profile');
Route::get('product-details/{id}', action: [FrontendController::class,'ProductDetails'])->name('product-details');
Route::get('/cart/navbar', [FrontendController::class, 'navbarCart'])->name('cart.navbar');

// Route::get('product-details/{id}', action: [FrontendController::class,'ProductDetails'])->name('product-details');
// Route::get('/product/{id}', [FrontendController::class, 'ProductShow'])->name('product.show');
// AUTH
Route::post('/signup-store', [AuthController::class, 'store'])->name('signup.store');
Route::post('toggle-wishlist/{id}', [FrontendController::class, 'toggleWishlist']);
Route::post('/toggle-wishlists/{id}', [FrontendController::class, 'toggleWishlist'])->name('toggle.wishlist');
Route::post('/login-ajax', [AuthController::class, 'login'])->name(name: 'login.ajax');
Route::get('/wishlist/data', [FrontendController::class, 'wishlistData'])->name('wishlist.data');
Route::post('/add-to-cart/{id}', [FrontendController::class, 'addToCart'])->name('cart.add');
Route::post('/address/update/{id}', [FrontendController::class, 'updateAddress'])->name('address.update');

Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/cart/items', [FrontendController::class, 'getCartItems'])->name('cart.items');
Route::post('/cart/remove/{id}', [FrontendController::class, 'removeCartItem']);
Route::post('/cart/update/{id}', [FrontendController::class, 'updateCartItem'])->name('cart.update');
Route::post('/cart/remove/{id}', [FrontendController::class, 'removeCartItem'])->name('cart.remove');
Route::post('/cart/apply-discount', [FrontendController::class, 'applyDiscount'])->name('cart.applyDiscount');

Route::post('/address/store', [FrontendController::class, 'storeAddress'])->name('address.store');


Route::get('/admin-dashboard', [AdminController::class,'Dashboard'])->name('adminhome');
Route::get('/admin-product', [AdminController::class,'Product'])->name('productpage');
Route::get('/admin-category', [AdminController::class,'Categories'])->name('categoriespage');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'Store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categoryupdate');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/admin-products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/coupon', [AdminController::class, 'Coupon'])->name('couponpage');
Route::post('/admin/coupons', [CouponController::class, 'store'])->name('coupons.store');
Route::get('/admin/coupons/list', [CouponController::class, 'datatable'])->name('coupons.datatable');
Route::get('/coupons/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
Route::put('/coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');

