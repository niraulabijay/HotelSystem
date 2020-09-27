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

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/create-super/{email}','authentication\RegistrationController@createAdmin');

//Authentication Routes
Route::post('/logout', 'authentication\LogController@logout')->name('logout');
Route::post('/admin/login/', 'authentication\LogController@check')->name('login_check');
Route::group([
    'namespace'=>'authentication',
    'middleware' => 'visitor'
], function () {

    Route::get('/', 'LogController@login')->name('admin_login');
    Route::get('/register', 'RegistrationController@register')->name('register');
//    Route::get('/login','LogController@admin_login')->name('admin_login');
    Route::get('/forgot_password','ForgotPasswordController@forgot_password')->name('forgot_password');
    Route::POST('/post_forgot_password','ForgotPasswordController@post_forgot_password')->name('post_forgot_password');

    //activation
    Route::get('/activate/{email}/{activationCode}','authentication\ActivationController@activate');

    Route::post('/store', 'authentication\RegistrationController@store')->name('register_user');

    //forgot_password
    Route::get('/reset_password/{email}/{code}','authentication\ForgotPasswordController@reset');
    Route::post('/reset_password/{email}/{code}','authentication\ForgotPasswordController@post_reset')->name('post_password_reset');

});


Route::group([
    'prefix' => '/admin',
    'namespace'=>'admin',
    'as' => 'admin.',
    'middleware' => 'sentinel'
], function () {

    //dashboard
    Route::get('/',function(){
        return view('admin.index');
    })->name('dashboard');

    //Hotel Brands
    Route::get('/brands','BrandController@index')->name('brands');
    Route::post('/brand/add','BrandController@add')->name('brands.add');
    Route::get('/brand/edit/{id}','BrandController@edit')->name('brands.edit');
    Route::post('/brand/edit/{id}','BrandController@update')->name('brands.update');
    Route::post('/brand/delete','BrandController@delete')->name('brands.delete');

    //Hotels
    Route::get('/hotels','HotelController@index')->name('hotels');
    Route::post('/hotel/add','HotelController@add')->name('hotels.add');
    Route::get('/hotel/edit/{id}','HotelController@edit')->name('hotels.edit');
    Route::post('/hotel/edit/{id}','HotelController@update')->name('hotels.update');
    Route::post('/hotel/delete','HotelController@delete')->name('hotels.delete');

    //Room Types
    Route::get('/room-types','RoomTypeController@index')->name('roomType');
    Route::get('/room-type/add/{hotel_slug}','RoomTypeController@add')->name('roomType.add');
    Route::post('/room-type/add','RoomTypeController@store')->name('roomType.store');

});
