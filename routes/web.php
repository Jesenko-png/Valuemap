<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
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
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'store'])->name('login.store');
    Route::post('/register', [AdminAuthController::class, 'register'])->middleware('throttle:4,60')->name('register');
});

Route::get('/admin/login', fn () => redirect()->route('login'))->name('admin.login');
Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/logout', [AdminAuthController::class, 'destroy'])->name('logout');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminContentController::class, 'index'])->name('admin.index');
    Route::get('/content/create', [AdminContentController::class, 'create'])->name('admin.content.create');
    Route::post('/content', [AdminContentController::class, 'store'])->name('admin.content.store');
    Route::get('/content/{contentItem}/edit', [AdminContentController::class, 'edit'])->name('admin.content.edit');
    Route::put('/content/{contentItem}', [AdminContentController::class, 'update'])->name('admin.content.update');
    Route::delete('/content/{contentItem}', [AdminContentController::class, 'destroy'])->name('admin.content.destroy');
    Route::middleware('main_admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    });
});
