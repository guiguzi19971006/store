<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DownloadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/download/{path}/{name?}', [DownloadController::class, 'download'])->name('download');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login')->withoutMiddleware('auth:api');
    Route::post('/login_process', [AdminAuthController::class, 'login_process'])->name('admin.login_process');
    Route::post('/logout_process', [AdminAuthController::class, 'logout_process'])->name('admin.logout_process');
    Route::get('/forget_password', [AdminAuthController::class, 'forget_password'])->name('admin.forget_password')->withoutMiddleware('auth:api');
    Route::post('/generate_user_forget_password_token', [AdminAuthController::class, 'generate_user_forget_password_token'])->name('admin.generate_user_forget_password_token');
    Route::get('/reset_password/{token}', [AdminAuthController::class, 'reset_password'])->name('admin.reset_password')->withoutMiddleware('auth:api');
    
    Route::group(['prefix' => 'products', 'middleware' => 'admin'], function () {
        Route::get('/search', [ProductController::class, 'search'])->name('admin.products.search')->withoutMiddleware('auth:api');
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index')->withoutMiddleware('auth:api');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create')->withoutMiddleware('auth:api');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('admin.products.show')->withoutMiddleware('auth:api');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit')->withoutMiddleware('auth:api');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});
