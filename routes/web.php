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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', 'HomeController@getAbout')->name('about');

Auth::routes();

Route::get('/home', 'HomeController@index');

//UTILIZADOR
Route::get('/user/{id}', [
    'as' => 'user.show',
    'uses' => 'UserController@showUser'
]);

Route::post('/user/{id}', 'UserController@updateAvatar');

//ADMIN
Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', 'AdminController@showDashboard')->name('admin.dashboard');
});
