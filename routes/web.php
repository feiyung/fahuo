<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','OrderController@login');
Route::post('/login_in','OrderController@login_in');
Route::group(['middleware' => 'login'],function(){
    Route::get('/loginout','OrderController@loginout');
    Route::get('/order/nosend','OrderController@noSendOrder');
    Route::get('/order/hadsent','OrderController@hadsentOrder');
    Route::post('/order/product','OrderController@product');
    Route::post('/order/delivery','OrderController@delivery');
    Route::post('/order/deliveryall','OrderController@deliveryAll');
    Route::get('/order/orderdetail/{id}','OrderController@orderDetail')->where('id', '[0-9]+');
    Route::get('/order/excel/{id}','OrderController@downLoadExcel')->where('id', '[0-9]+');
});

