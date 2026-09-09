<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/structure', [PageController::class, 'structure'])->name('structure');
Route::get('/consortium', [PageController::class, 'consortium'])->name('consortium');
Route::get('/ecosystem', [PageController::class, 'ecosystem'])->name('ecosystem');
Route::get('/results', [ContentController::class, 'results'])->name('results');
Route::get('/news-media', [ContentController::class, 'news'])->name('news');
Route::get('/library/{contentItem:slug}', [ContentController::class, 'show'])->name('content.show');
Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,60')->name('contact.store');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminContentController::class, 'index'])->name('admin.index');
    Route::get('/content/create', [AdminContentController::class, 'create'])->name('admin.content.create');
    Route::post('/content', [AdminContentController::class, 'store'])->name('admin.content.store');
    Route::get('/content/{contentItem}/edit', [AdminContentController::class, 'edit'])->name('admin.content.edit');
    Route::put('/content/{contentItem}', [AdminContentController::class, 'update'])->name('admin.content.update');
    Route::delete('/content/{contentItem}', [AdminContentController::class, 'destroy'])->name('admin.content.destroy');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('admin.logout');
});
