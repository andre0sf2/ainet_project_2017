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

Route::get('/about', 'HomeController@about')->name('about');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

//UTILIZADOR
Route::get('/user/{id}', [
    'as' => 'user.show',
    'uses' => 'UserController@showUser'
]);

Route::get('/users', 'UserController@listUsers')->name('users.list');

Route::get('/unauthorized', 'HomeController@unauthorized')->name('unauthorized');


//PASSWORD RESET
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@passwordReset')->name('password.reset');
Route::get('/password/reset', 'Auth\ResetPasswordController@passwordReset')->name('password.reset');
Route::get('/password/email', 'Auth\ForgotPasswordController@emailPassword')->name('password.email');


//AUTH
Route::get('/login', 'HomeController@login')->name('auth.login');
Route::get('/register', 'HomeController@register')->name('auth.register');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/user/edit/{id}', [
        'as' => 'user.edit',
        'uses' => 'UserController@editUser'
    ]);
    Route::post('/user/{id}', [
        'as' => 'user.update',
        'uses' => 'UserController@updateUser'
    ]);

    Route::get('/print/request', 'RequestController@createRequest')->name('print.request');
    Route::get('/list/request', 'RequestController@listRequest')->name('request.list');
    //rota para detalhes dos pedidos
    Route::get('/request/{id}', 'RequestController@viewRequest')->name('request.view');

    Route::post('/request/subcomment/{id}', 'CommentController@insertSubComment')->name('request.subComment');
    Route::post('/request/comment/{id}', 'CommentController@insertComment')->name('request.comment');


    //ADMIN
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/dashboard', 'AdminController@showDashboard')->name('admin.dashboard');

        Route::post('/users/block', 'UserController@blockUser')->name('user.block');
        Route::post('/users/unblock', 'UserController@unblockUser')->name('user.unblock');

        Route::post('/comment/block', 'CommentController@blockComment')->name('comment.block');
        Route::post('/comment/unblock', 'CommentController@unblockComment')->name('comment.unblock');


        Route::post('/users/grant', 'AdminController@grantAdmin')->name('admin.grant');
        Route::post('/users/revoke', 'AdminController@revokeAdmin')->name('admin.revoke');

        Route::post('/request/accept', 'RequestController@acceptRequest')->name('request.accept');
        Route::post('/request/refuse', 'RequestController@refuseRequest')->name('request.refuse');
    });
});


