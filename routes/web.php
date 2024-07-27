<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware(['auth'])->group(function () {
    Route::get('account-dashboard', [UserController::class, 'index'])->name('user.index');
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
    Route::post('admin/categories/store', [AdminController::class,'storeCategory'])->name('admin.categories_store');
    Route::get('/categories/edit/{id}', [AdminController::class, 'CategoryEdit'])->name('categories.edit');
    Route::post('/categories/{id}', [AdminController::class, 'CategoryUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'CategoryDestroy'])->name('categories.destroy');
    //Products routes
    Route::get('admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('admin/products/new', [AdminController::class, 'ProductsCreate'])->name('admin.products.create');
    Route::post('admin/products/store', [AdminController::class, 'ProductsStore'])->name('admin.products.store');
});
