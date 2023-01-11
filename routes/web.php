<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'index']);

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [AuthController::class, 'signIn'])->name('signIn');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'signUp'])->name('signUp');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});
Route::post('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');


Route::get('/products', [ProductController::class, 'index'])->name('products');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store'])->name('cart.post');
Route::put('/cart/quantity', [CartController::class, 'update'])->name('cart.update');
Route::put('/cart/delete/product', [CartController::class, 'deleteProductFromCart'])->name('cart.delete.product');
Route::delete('/cart/delete', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply_coupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove_coupon');
