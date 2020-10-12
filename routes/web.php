<?php

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

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
  Route::resource('purchases', 'App\Http\Controllers\Admin\PurchaseController');
  Route::get('purchase-list', 'App\Http\Controllers\Admin\PurchaseController@purchaseDataTable')->name('purchase-list');
  Route::get('purchase-select', 'App\Http\Controllers\Admin\PurchaseController@purchaseSelect')->name('purchase-select');
  Route::get('purchases/duplicate/{id}', 'App\Http\Controllers\Admin\PurchaseController@duplicateOrder');

  Route::resource('markings', 'App\Http\Controllers\Admin\MarkingController');
  Route::get('marking-list', 'App\Http\Controllers\Admin\MarkingController@markingDataTable')->name('marking-list');
  Route::get('marking-select', 'App\Http\Controllers\Admin\MarkingController@markingSelect')->name('marking-select');

  Route::resource('items', 'App\Http\Controllers\Admin\ItemController');
  Route::get('item-list', 'App\Http\Controllers\Admin\ItemController@itemDataTable')->name('item-list');
  Route::get('item-select', 'App\Http\Controllers\Admin\ItemController@itemSelect')->name('item-select');

  Route::resource('payments','App\Http\Controllers\Admin\PaymentController');
  Route::get('payment-list', 'App\Http\Controllers\Admin\PaymentController@paymentDataTable')->name('payment-list');
  Route::get('payments/download/{id}', 'App\Http\Controllers\Admin\PaymentController@download');
  Route::get('payments/add-payment/{id}', 'App\Http\Controllers\Admin\PaymentController@addPayment');
});