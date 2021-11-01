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
    
    Route::group(['prefix' => 'product'], function () {
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/', [ProductController::class, 'store'])->name('admin.product.store');
    });
});
