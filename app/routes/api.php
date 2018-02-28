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
use \App\Http\Resources\ProductResource;

/*Route::middleware('auth:api')->get('/product', function (Request $request) {
    return new ProductResource(Product::find(1));
});*/

Route::middleware('auth:api')->resource('products', 'Admin\Api\ProductsController');

Route::middleware('csrf')->post('/checkout-process', [
    'as'         => 'checkout.process',
    'uses'       => 'StoreController@checkoutProcess',
    'middleware' => 'only.ajax',
]);


