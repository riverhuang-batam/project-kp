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
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
  Route::resource('purchases', 'App\Http\Controllers\Admin\PurchaseController');
  Route::get('purchase-list/{status}', 'App\Http\Controllers\Admin\PurchaseController@purchaseDataTable');
  Route::get('purchase-select', 'App\Http\Controllers\Admin\PurchaseController@purchaseSelect')->name('purchase-select');
  Route::get('purchases/duplicate/{id}', 'App\Http\Controllers\Admin\PurchaseController@duplicateOrder');
  Route::get('purchases/details/{id}', 'App\Http\Controllers\Admin\PurchaseController@getPurchaseDetails');
  Route::get('purchases-counter', 'App\Http\Controllers\Admin\PurchaseController@countBadge');
  Route::get('purchases-total/{id}', 'App\Http\Controllers\Admin\PurchaseController@totalPayment');
  Route::post('purchases-status','App\Http\Controllers\Admin\PurchaseController@updateStatus');
  Route::get('purchases/invoice/{id}', 'App\Http\Controllers\Admin\PurchaseController@invoice');

  Route::resource('sales', 'App\Http\Controllers\Admin\SaleController');
  Route::get('sale-list/{status}', 'App\Http\Controllers\Admin\SaleController@saleDataTable');
  Route::get('sale-select', 'App\Http\Controllers\Admin\SaleController@saleSelect')->name('sale-select');
  Route::get('sales/details/{id}', 'App\Http\Controllers\Admin\SaleController@getSaleDetails');
  Route::get('sales/invoice/{id}', 'App\Http\Controllers\Admin\SaleController@invoice');

  Route::resource('markings', 'App\Http\Controllers\Admin\MarkingController');
  Route::get('marking-list', 'App\Http\Controllers\Admin\MarkingController@markingDataTable')->name('marking-list');
  Route::get('marking-select', 'App\Http\Controllers\Admin\MarkingController@markingSelect')->name('marking-select');

  Route::resource('products', 'App\Http\Controllers\Admin\ProductController');
  Route::get('product-list', 'App\Http\Controllers\Admin\ProductController@productDataTable')->name('product-list');
  Route::get('product-select', 'App\Http\Controllers\Admin\ProductController@productSelect')->name('product-select');
  Route::get('product/selected/{id}', 'App\Http\Controllers\Admin\ProductController@productSelected');
  Route::get('product/details/{id}', 'App\Http\Controllers\Admin\ProductController@productDetail');

  Route::resource('payments','App\Http\Controllers\Admin\PaymentController');
  Route::get('payment-list', 'App\Http\Controllers\Admin\PaymentController@paymentDataTable')->name('payment-list');
  Route::get('payments/download/{id}', 'App\Http\Controllers\Admin\PaymentController@download');
  Route::get('payments/add-payment/{id}', 'App\Http\Controllers\Admin\PaymentController@addPayment');

  Route::resource('suppliers', 'App\Http\Controllers\Admin\SupplierController');
  Route::get('supplier-list', 'App\Http\Controllers\Admin\SupplierController@supplierDataTable')->name('supplier-list');
  Route::get('supplier-select', 'App\Http\Controllers\Admin\SupplierController@supplierSelect')->name('supplier-select');

  Route::resource('jurnals', 'App\Http\Controllers\Admin\JurnalController');
  Route::get('jurnal-list', 'App\Http\Controllers\Admin\JurnalController@jurnalDataTable')->name('jurnal-list');

  Route::resource('akuns', 'App\Http\Controllers\Admin\AkunController');
  Route::get('akun-list', 'App\Http\Controllers\Admin\AkunController@akunDataTable')->name('akun-list');
  Route::get('akun-select', 'App\Http\Controllers\Admin\AkunController@akunSelect')->name('akun-select');

  Route::get('laba-rugi', 'App\Http\Controllers\Admin\LabaRugiController@index')->name('laba-rugi.index');
  Route::post('laba-rugi', 'App\Http\Controllers\Admin\LabaRugiController@print')->name('laba-rugi.print');

  Route::get('perubahan-modal', 'App\Http\Controllers\Admin\CapitalController@index')->name('perubahan-modal.index');
  Route::post('perubahan-modal', 'App\Http\Controllers\Admin\CapitalController@print')->name('perubahan-modal.print');

  Route::get('neraca', 'App\Http\Controllers\Admin\NeracaController@index')->name('neraca.index');
  Route::post('neraca', 'App\Http\Controllers\Admin\NeracaController@print')->name('neraca.print');
}); 