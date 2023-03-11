<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\CouponsController;
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

Route::resource('shop', ShopController::class);
Route::resource('', LandingPageController::class);
Route::resource('cart', CartController::class);
Route::group(['as' => 'cart.', 'prefix' => 'cart'], function() {
    Route::post('/switchToSaveForLater/{id}', [CartController::class, 'switchToSaveForLater'])->name('switchToSaveForLater');
});
Route::resource('saveForLater', SaveForLaterController::class);
Route::group(['as' => 'saveForLater.', 'prefix' => 'saveForLater'], function() {
    Route::post('/moveToCart/{id}', [SaveForLaterController::class, 'moveToCart'])->name('moveToCart');
});

Route::group(['as' => 'checkout.', 'prefix' => 'checkout'], function() {
    Route::get('/', [CheckoutController::class, 'index'])->name('index')->middleware('auth');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/guest', [CheckoutController::class, 'index'])->name('guest.index');

});

Route::group(['as' => 'coupon.', 'prefix' => 'coupon'], function() {
    Route::post('/', [CouponsController::class, 'store'])->name('store');
    Route::delete('/', [CouponsController::class, 'destroy'])->name('destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

