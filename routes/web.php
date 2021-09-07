<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
// Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::resource('invoices', InvoiceController::class);
    Route::resource('attachs', InvoiceAttachmentController::class);
    
    Route::resource('sections', SectionController::class);
    Route::get('get-products/{id}', [InvoiceController::class, 'getProducts']);
    
    Route::resource('products', ProductController::class);

    Route::get('/{page}', [AdminController::class, 'index']);
});
