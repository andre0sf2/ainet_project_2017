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

// INDEX
Route::get('/', 'HomeController@index')->name('index');

Route::get('/about', 'HomeController@getAbout')->name('about');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//UTILIZADOR
Route::get('/user/{id}', [
    'as' => 'user.show',
    'uses' => 'UserController@showUser'
]);
Route::get('/users', 'UserController@listUsers')->name('users.list');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/user/edit/{id}', [
        'as' => 'user.edit',
        'uses' => 'UserController@editUser'
    ]);
    Route::post('/user/{id}', [
        'as' => 'user.update',
        'uses' => 'UserController@updateUser'
    ]);
});

//ADMIN
Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', 'AdminController@showDashboard')->name('admin.dashboard');
    Route::post('/users/block', 'UserController@blockUser')->name('user.block');
    Route::post('/users/revoke', 'AdminController@revokeAdminFromUser')->name('admin.revoke');
});
