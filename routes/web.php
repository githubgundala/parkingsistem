<?php

use App\http\middleware\IsAdmin;
use App\http\middleware\IsOperator;
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

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::get('/maps', 'HomeController@index');

Auth::routes();

Route::group(['middleware' => IsAdmin::class], function () {
    Route::resource('customer', 'CustomerController');
    Route::post('/updateImgParking/{id}', 'CustomerController@updateImg');
    Route::resource('role', 'RoleController');
    Route::resource('pricing', 'PriceController');
    Route::resource('kategori', 'KategoriController');
    Route::resource('user', 'UserController');
    Route::get('admin', 'UserController@dashboard');
    Route::resource('userop', 'UserOPController');
});

Route::group(['middleware' => IsOperator::class], function () {
    Route::post('/UpdatePass/{id}', 'OperatorController@UpdatePass');
    Route::resource('transaksi', 'TransaksiController');
    Route::get('/laporan', 'TransaksiController@laporan');
    Route::post('/daily', 'TransaksiController@daily');
    Route::post('/checkout_parking', 'TransaksiController@checkout');
    Route::get('/operator/getHarga/{id}', 'TransaksiController@getHarga');
    Route::resource('operator', 'OperatorController');
});