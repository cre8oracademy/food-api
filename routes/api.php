<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Errors;
use App\Http\Controllers\genralController;
use Illuminate\Support\Facades\Password;

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

Route::group([
    'middlewere' => "api",
    'namespace' => "App\Http\Controllers",
    'prefix' => "auth"
], function ($router) {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login');
    Route::post('logout', 'UserController@logout');
    Route::put('profile_update', 'UserController@profile_update');
    Route::get('profile', 'UserController@profile');
    Route::post('refresh', 'UserController@refresh');
    Route::put('password/reset', 'UserController@sendResetResponse')->name('password.reset');
    Route::post('forgot_password', 'UserController@sendResetLinkResponse');
    Route::post('profile_pic_upload', 'UserController@profile_pic_upload');
    Route::get('password/email', 'UserController@showLinkRequestForm')->name('password.email');
    Route::post('password/email', 'UserController@sendResetLinkEmail');
    Route::get('email/verify/{id}', 'UserController@verify')->name('verification.verify');
    Route::get('email/resend', 'UserController@resend')->name('verification.resend');
});
Route::group([
    'middlewere' => "api",
    'namespace' => "App\Http\Controllers",
    'prefix' => "product"
], function ($router) {
    Route::post('create', 'productController@create');
    Route::post('update', 'productController@update');
    Route::delete('delete/{product_id}', 'productController@delete');
    Route::put('activate_switch', 'productController@activate_switch');
    Route::post('alergic', 'productController@alergic');
    Route::post('custum_order', 'productController@custum_order');
    Route::post('custum_order_disable', 'productController@custum_order_disable');
    Route::post('update_ingredients', 'productController@add_ingredients');
    Route::get('get_ingredients', 'productController@get_ingredients');
    Route::get('get_product', 'productController@get_product');
    Route::get('/{product_uid}', 'productController@get_single_product');
    Route::post('upload_images', 'productController@upload_images');
    Route::post('get_images', 'productController@get_images');
});
Route::group([
    'middlewere' => "api",
    'namespace' => "App\Http\Controllers",
    'prefix' => "order"
], function ($router) {
    Route::post('place_order', 'ordersController@place_order');
    Route::post('cancel', 'ordersController@cancel');
    Route::post('accept', 'ordersController@accept');
    Route::get('completed', 'ordersController@completed');
    Route::get('canceled', 'ordersController@canceled');
    Route::get('active', 'ordersController@active');
    Route::get('order_details/{order_uid}', 'ordersController@order_details');
});
Route::group([
    'middlewere' => "api",
    'namespace' => "App\Http\Controllers",
    'prefix' => "review"
], function ($router) {
    Route::post('add', 'reviewsController@add');
    //get all reviews
    Route::get('get_reviews/{product_id}', 'reviewsController@get_reviews');
    Route::get('get_user_reviews/{product_id}', 'reviewsController@get_user_reviews');
});
Route::group([
    'middlewere' => "api",
    'namespace' => "App\Http\Controllers",
    'prefix' => "message"
], function ($router) {
    Route::post('send', 'chatController@send');
    Route::get('recive', 'chatController@recive');
});
Route::group([
    'middlewere' => "auth.role",
    'namespace' => "App\Http\Controllers",
    'prefix' => "admin"
], function ($router) {
    Route::post('create_catagory', 'adminController@create_catagory');
    Route::get('total_users', 'adminController@total_users');
    Route::delete('delete_user/{username}', 'adminController@delete_user');
    Route::post('cancel_order', 'adminController@cancel_order');
    Route::get('reports', 'adminController@reports');
    //orders
    Route::get('orders', 'adminController@orders');
});
Route::get('error', [Errors::class, 'errors']);
Route::post('report', [genralController::class, 'report']);
Route::get('search/{query?}', [genralController::class, 'search'])->where('query', '[A-Za-z]+');