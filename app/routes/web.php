<?php

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

Route::get('/', ['as' => 'store.list', 'uses' => 'StoreController@getList']);
Route::get('/checkout', ['as' => 'store.checkout.page', 'uses' => 'StoreController@checkOut']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', ['uses' => 'Admin\OrdersController@getOrdersList']);
});

$this->get('/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('/login', 'Auth\LoginController@login');
$this->get('/logout', 'Auth\LoginController@logout')->name('logout');
