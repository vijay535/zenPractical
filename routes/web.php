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

/*Route::get('/', function () {
    return view('customer');
});*/
Route::get('/', 'CustomerController@index');
Route::get('/productRateUnit', 'CustomerController@getProductRate');
Route::post('/custAddProduct', 'CustomerController@getCustomerData');
Route::post('/product', 'CustomerController@store');
