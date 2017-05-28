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
Route::get('/user/{id}', 'HomeController@showUser')->name('user.show');
Route::get('/users', 'HomeController@listUsers')->name('users.list');

//Departamentos
Route::get('department/{id}', 'HomeController@departementInfo')->name('department.info');

Route::get('/unauthorized', 'HomeController@unauthorized')->name('unauthorized');
Route::get('/ativated', 'HomeController@ativated')->name('ativated');

//PASSWORD RESET
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@passwordReset')->name('password.reset');
Route::get('/password/reset', 'Auth\ResetPasswordController@passwordReset')->name('password.reset');
Route::get('/password/email', 'Auth\ForgotPasswordController@emailPassword')->name('password.email');


//AUTH
Route::get('/login', 'HomeController@login')->name('auth.login');
Route::get('/register', 'HomeController@register')->name('auth.register');

Route::get('/register/verify/{token}', 'HomeController@activeUser')->name('activated.user');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/user/edit/{id}', 'UserController@editUser')->name('user.edit');
    Route::post('/user/{id}', 'UserController@updateUser')->name('user.update');

    Route::post('/rating', 'RequestController@rating')->name('rating');

    Route::get('/print/request', 'RequestController@createRequest')->name('print.request');
    Route::post('/print/request', 'RequestController@insertRequest')->name('print.insert');

    //Requests do utilizador
    Route::get('/myRequests', 'RequestController@userRequests')->name('request.user');

    Route::get('/list/request', 'RequestController@listRequest')->name('request.list');
    
    //rota para detalhes dos pedidos
    Route::get('/request/{id}', 'RequestController@viewRequest')->name('request.view');

    Route::post('/request/subcomment/{id}', 'CommentController@insertSubComment')->name('request.subComment');
    Route::post('/request/comment/{id}', 'CommentController@insertComment')->name('request.comment');

    Route::get('/request/edit/{id}', 'RequestController@editRequest')->name('request.edit');
    Route::post('/request/edit/{id}', 'RequestController@updateRequest')->name('request.update');
    Route::delete('request/delete/{id}', 'RequestController@destroy')->name('request.delete');

    //ADMIN
    Route::group(['middleware' => 'admin'], function () {

        Route::get('/dashboard', 'AdminController@showDashboard')->name('admin.dashboard');

        Route::post('/users/block', 'AdminController@blockUser')->name('user.block');
        Route::post('/users/unblock', 'AdminController@unblockUser')->name('user.unblock');

        Route::post('/comment/block', 'CommentController@blockComment')->name('comment.block');
        Route::post('/comment/unblock', 'CommentController@unblockComment')->name('comment.unblock');

        Route::post('/users/grant', 'AdminController@grantAdmin')->name('admin.grant');
        Route::post('/users/revoke', 'AdminController@revokeAdmin')->name('admin.revoke');

        //Verificar melhor estas rotas
        //se aceitar escolher a impressora
        //recusar dizer porque
        Route::get('/request/accept/{id}', 'AdminController@acceptView')->name('request.accept');
        Route::post('/accept', 'AdminController@acceptRequest')->name('accept');
        Route::get('/request/refuse/{id}', 'AdminController@refuseView')->name('request.refuse');
        Route::post('/refuse', 'AdminController@refuseRequest')->name('refuse');
    });
});


