<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MpController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [MpController::class, 'index'])->name('mps.index');
Route::get('/mps/{mp}', [MpController::class, 'show'])->name('mps.show');

// Route for showing signatures
Route::get('/mps/{mp}/signatures', [MpController::class, 'showSignatures'])->name('mps.show-signatures');

// Route for downloading PDF
Route::get('/mps/{mp}/pdf', [MpController::class, 'downloadPdf'])->name('mps.download-pdf');

// Route for the recall form
Route::get('/mps/{mp}/recall', [MpController::class, 'recallForm'])->name('mps.recall-form');
Route::post('/mps/{mp}/recall', [SignatureController::class, 'store'])->name('mps.recall-store');

// Route for storing signatures
Route::post('/signatures', [SignatureController::class, 'store'])->name('signatures.store');

// Protected routes under 'auth' middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/{mp}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{mp}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/{mp}', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// Authentication routes provided by Laravel
Auth::routes();

// Example home route for authenticated users
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');
