<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/products', 'ProductController@index');
Route::post('/product', 'ProductController@create');
Route::post('/product/buy', 'ProductController@buy');

Route::get('/discounts', 'DiscountController@index');

Route::get('/vouchers', 'VoucherController@index');
Route::post('/voucher', 'VoucherController@create');