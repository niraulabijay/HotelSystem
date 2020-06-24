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


});
