<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;

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

// 商品
Route::get('/', [MerchandiseController::class, 'home'])->name('home');
Route::group(['prefix' => 'merchandise'], function() {
    Route::post('/index', [MerchandiseController::class, 'index'])->name('merchandise.index');
    Route::get('/{id}/show', [MerchandiseController::class, 'show'])->name('merchandise.show');
    Route::get('/search', [MerchandiseController::class, 'search'])->name('merchandise.search');
});
// 購物車
Route::group(['prefix' => 'cart'], function() {
    Route::get('/', [CartController::class, 'home'])->name('cart.home');
    Route::post('/index', [CartController::class, 'index'])->name('cart.index');
    Route::post('/store', [CartController::class, 'store'])->name('cart.store');
    Route::post('/delete', [CartController::class, 'delete'])->name('cart.delete');
});
// 會員
Route::group(['prefix' => 'user'], function() {
    Route::get('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/registerProcess', [UserController::class, 'registerProcess'])->name('user.registerProcess');
    Route::get('/login', [UserController::class, 'login'])->name('user.login');
    Route::post('/loginProcess', [UserController::class, 'loginProcess'])->name('user.loginProcess');
    Route::post('/logoutProcess', [UserController::class, 'logoutProcess'])->name('user.logoutProcess');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/forgetPassword', [UserController::class, 'forgetPassword'])->name('user.forgetPassword');
    Route::post('/forgetPasswordProcess', [UserController::class, 'forgetPasswordProcess'])->name('user.forgetPasswordProcess');
    Route::get('/{id}/resetPassword/{token}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
    Route::post('/{id}/resetPasswordProcess/{token}', [UserController::class, 'resetPasswordProcess'])->name('user.resetPasswordProcess');
});
// 使用者行為
Route::group(['prefix' => 'activity'], function() {
    Route::post('/store', [ActivityController::class, 'store'])->name('activity.store');
});
