<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminAuthController;

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

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'login'])->name('admin.login')->withoutMiddleware('admin');
    Route::post('/login_process', [AdminAuthController::class, 'login_process'])->name('admin.login_process')->withoutMiddleware('admin');
    Route::post('/logout_process', [AdminAuthController::class, 'logout_process'])->name('admin.logout_process')->withoutMiddleware('admin');
    Route::get('/forget_password', [AdminAuthController::class, 'forget_password'])->name('admin.forget_password')->withoutMiddleware('admin');
    Route::post('/generate_user_forget_password_token', [AdminAuthController::class, 'generate_user_forget_password_token'])->name('admin.generate_user_forget_password_token')->withoutMiddleware('admin');
    Route::get('/reset_password/{token}', [AdminAuthController::class, 'reset_password'])->name('admin.reset_password')->withoutMiddleware('admin');
    
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('admin.products.show');
    });
});
