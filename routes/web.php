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

    Route::get('paid-invoice', [InvoiceController::class, 'paid'])->name('invoices.paid');
    Route::get('part_paid-invoice', [InvoiceController::class, 'part_paid'])->name('invoices.part_paid');
    Route::get('unpaid-invoice', [InvoiceController::class, 'unpaid'])->name('invoices.unpaid');
    // 
    Route::get('archive-invoice', [InvoiceController::class, 'archivePage'])->name('invoices.archivePage');
    Route::post('invoices/archive/{id}', [InvoiceController::class, 'archive'])->name('invoices.archive');
    Route::post('invoices/unArchive/{id}', [InvoiceController::class, 'unArchive'])->name('invoices.unarchive');
    // 
    Route::get('invoices/editPayment/{id}', [InvoiceController::class, 'editPayment'])->name('invoices.editPayment');
    Route::post('invoices/updatePayment/{id}', [InvoiceController::class, 'updatePayment'])->name('invoices.updatePayment');
    Route::get('get-products/{id}', [InvoiceController::class, 'getProducts']);
    
    Route::get('invoices/print_info/{id}', [InvoiceController::class, 'print_info'])->name('invoices.print_info');
    
    Route::resource('attachs', InvoiceAttachmentController::class);
    
    Route::resource('sections', SectionController::class);
    
    Route::resource('products', ProductController::class);

    Route::get('/{page}', [AdminController::class, 'index']);
});
