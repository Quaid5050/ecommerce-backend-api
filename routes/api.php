<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\{
    ProductController,
    CategoryController,
    BrandController,
    PrinterModelController,
    SeriesController
};

// Default resource routes
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('brands', BrandController::class);
Route::apiResource('printer-models', PrinterModelController::class);
Route::apiResource('series', SeriesController::class);

// Additional routes
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('brands', 'getCategoriesWithBrands');
    Route::get('{id}/category-brands', 'getCategoryWithBrands');
    Route::post('{categoryId}/attach-brand/{brandId}', 'attachBrandWithCategory');
    Route::delete('{categoryId}/detach-brand/{brandId}', 'detachBrandFromCategory');
});

Route::prefix('brands')->controller(BrandController::class)->group(function () {
    Route::get('brands-categories', 'getBrandsWithCategories');
    Route::get('{id}/brand-categories', 'getBrandWithCategories');
    Route::get('{id}/brand-series', 'getBrandWithSeries');
    Route::get('{id}/brand-series-printer-models', 'getBrandWithSeriesAndPrinterModels');
});

Route::prefix('printer-models')->controller(PrinterModelController::class)->group(function () {
    Route::post('{printerModelId}/attach-product/{productId}', 'attachProductWithPrinterModel');
    Route::delete('{printerModelId}/detach-product/{productId}', 'detachProductFromPrinterModel');
    Route::get('printer-models-products', 'getPrinterModelsWithProducts');
    Route::get('{printerModelId}/printer-model-products', 'getPrinterModelWithProducts');
});

Route::prefix('products')->controller(ProductController::class)->group(function () {
    Route::get('products-printer-models', 'getProductsWithPrinterModels');
    Route::get('{productId}/product-printer-models', 'findProductWithPrinterModels');
});

Route::prefix('series')->controller(SeriesController::class)->group(function () {
    Route::get('series-printer-models', 'getSeriesWithPrinterModels');
    Route::get('{seriesId}/series-printer-models', 'findSeriesWithPrinterModels');
});
