<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriceTypeController;

Route::get('/', function () {
    return view('welcome');
});

// Category Table
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::post('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::post('categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::get('category/change-status', [CategoryController::class, 'ChangeStatus'])->name('category.changeStatus');

// Product Table
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('product/update/{id}', [ProductController::class, 'update'])->name('product.update');
Route::post('product/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('product/change-status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');

Route::post('product/price-list/{price_id}', [ProductController::class, 'priceListDestroy']); // For Product Price Delete

// Product Price Type Table
Route::get('all-price-types', [PriceTypeController::class, 'index'])->name('all.price-type');
Route::get('price-type/create', [PriceTypeController::class, 'create'])->name('price-type.create');
Route::post('price-type/store', [PriceTypeController::class, 'store'])->name('price-type.store');
Route::get('price-type/edit/{id}', [PriceTypeController::class, 'edit'])->name('price-type.edit');
Route::post('price-type/update/{id}', [PriceTypeController::class, 'update'])->name('price-type.update');
Route::get('price-type/destroy/{id}', [PriceTypeController::class, 'destroy'])->name('price-type.destroy');
Route::get('price-type/change-status', [PriceTypeController::class, 'changeStatus'])->name('price-type.changeStatus');
