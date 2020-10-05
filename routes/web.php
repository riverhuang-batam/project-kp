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
Auth::routes();

Route::middleware(['auth'])->group(function () {
  Route::resource('orders', 'App\Http\Controllers\Admin\OrderController');
  Route::get('orders/duplicate/{id}', 'App\Http\Controllers\Admin\OrderController@duplicateOrder');
  Route::resource('markings', 'App\Http\Controllers\Admin\MarkingController');
  Route::resource('items', 'App\Http\Controllers\Admin\ItemController');
  Route::get('order-list', 'App\Http\Controllers\Admin\OrderController@orderDataTable')->name('order-list');
  Route::get('marking-list', 'App\Http\Controllers\Admin\MarkingController@markingDataTable')->name('marking-list');
  Route::get('marking-select', 'App\Http\Controllers\Admin\MarkingController@markingSelect')->name('marking-select');
  Route::get('item-list', 'App\Http\Controllers\Admin\ItemController@itemDataTable')->name('item-list');
  Route::get('item-select', 'App\Http\Controllers\Admin\ItemController@itemSelect')->name('item-select');
});