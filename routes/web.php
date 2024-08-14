<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product_details');

Route::get('/shop/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/shop/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/shop/cart/increase/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.increase');
Route::put('/shop/cart/decrease/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_cart_item'])->name('cart.remove');
Route::delete('/shop/cart/clear', [CartController::class, 'clear_cart'])->name('cart.clear');

Route::post('/shop/cart/apply-coupon', [CartController::class, 'apply_coupon'])->name('cart.apply_coupon');

Route::delete('/shop/cart/remove-coupon', [CartController::class, 'remove_coupon'])->name('cart.remove_coupon');

Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::post('/place-an-order',[CartController::class, 'place_order'])->name('cart.place_order');




Route::post('/wishlist/add', [WishlistController::class, 'add_wishlist'])->name('wishlist.add');
Route::get('/show/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/shop/cart/remove/{rowId}', [WishlistController::class, 'remove_wishlist_item'])->name('wishlist.remove');
Route::delete('/wishlist/clear', [WishlistController::class, 'wishlist_clear'])->name('wishlist.clear');
Route::post('/wishlist/move/cart/{rowId}', [WishlistController::class, 'wishlist_move_item'])->name('wishlist.move.cart');

Route::get('order-confirmation',[CartController::class, 'order_confirmation'])->name('cart.order_confirmation');


Route::middleware(['auth'])->group(function () {
    Route::get('account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('account-orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('account-order-details/{id}', [UserController::class, 'order_details'])->name('user.order_details');
});



Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    //Brand routes
    Route::get('admin/brands', [AdminController::class, 'brands'])->name('admin.brand');
    Route::get('admin/brands/new', [AdminController::class, 'addBrand'])->name('admin.brand_new');
    Route::post('admin/brands/store', [AdminController::class, 'brands_store'])->name('admin.brands_store');
    Route::get('/brands/edit/{id}', [AdminController::class, 'edit'])->name('admin.brands_edit');
    Route::post('/brands/{id}', [AdminController::class, 'update'])->name('admin.brands_update');
    Route::delete('/brands/{id}', [AdminController::class, 'destroy'])->name('admin.brands_destroy');
    //Categories routes
    Route::get('admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('admin/categories/new', [AdminController::class, 'addCategory'])->name('admin.categories_new');
    Route::post('admin/categories/store', [AdminController::class, 'storeCategory'])->name('admin.categories_store');
    Route::get('/categories/edit/{id}', [AdminController::class, 'CategoryEdit'])->name('categories.edit');
    Route::post('/categories/{id}', [AdminController::class, 'CategoryUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'CategoryDestroy'])->name('categories.destroy');
    //Products routes
    Route::get('admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('admin/products/new', [AdminController::class, 'ProductsCreate'])->name('admin.products.create');
    Route::post('admin/products/store', [AdminController::class, 'ProductsStore'])->name('admin.products.store');
    Route::get('/products/edit/{id}', [AdminController::class, 'ProductsEdit'])->name('admin.products.edit');
    Route::post('/products/{id}', [AdminController::class, 'ProductsUpdate'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'ProductDestroy'])->name('admin.products.destroy');
    Route::get('/product-show/{id}', [AdminController::class, 'ProductsShow'])->name('admin.products.show');

    //Coupons routes
    Route::get('admin/coupons', [AdminController::class, 'coupans'])->name('admin.coupons');
    Route::get('admin/coupons/new', [AdminController::class, 'addCoupon'])->name('admin.coupons_new');
    Route::post('admin/coupons/store', [AdminController::class, 'storeCoupon'])->name('admin.coupons_store');
    Route::get('/coupons/edit/{id}', [AdminController::class, 'CouponEdit'])->name('coupons.edit');
    Route::post('/coupons/{id}', [AdminController::class, 'updateCoupon'])->name('coupons.update');
    Route::delete('/coupons/{id}', [AdminController::class, 'CouponDestroy'])->name('coupons.destroy');

    //Orders routes
    Route::get('admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/order-show/{order_id}', [AdminController::class, 'order_details'])->name('admin.order.show');
    Route::put('/admin/orders/{id}/update-status', [AdminController::class, 'update_order_status'])->name('admin.order_status_update');
});
