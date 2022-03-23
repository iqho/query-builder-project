<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriceTypeController;

Route::get('/', function () {
    return view('welcome');
});

// Category Table
Route::get('category/change-status', [CategoryController::class, 'ChangeStatus'])->name('category.changeStatus');
Route::resource('categories', CategoryController::class);

// Product Table
Route::get('products/change-status', [ProductController::class, 'ChangeStatus'])->name('product.changeStatus');

Route::post('product/price-list/{price_id}', [ProductController::class, 'priceListDestroy']); // For Product Price List Delete

Route::resource('products', ProductController::class);

// Product Price Type Table
Route::get('all-price-types', [PriceTypeController::class, 'index'])->name('all.price-type');

Route::get('price-type/create', [PriceTypeController::class, 'create'])->name('price-type.create');
Route::post('price-type/store', [PriceTypeController::class, 'store'])->name('price-type.store');

Route::get('price-type/edit/{ptype}', [PriceTypeController::class, 'edit'])->name('price-type.edit');
Route::post('price-type/update/{ptype}', [PriceTypeController::class, 'update'])->name('price-type.update');

Route::get('price-type/destroy/{ptype}', [PriceTypeController::class, 'destroy'])->name('price-type.destroy');

Route::get('price-type/change-status', [PriceTypeController::class, 'ChangeStatus'])->name('price-type.changeStatus');
