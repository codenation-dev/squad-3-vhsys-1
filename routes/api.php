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

Route::post('/login', ['as' => 'login.entrar', 'uses' => 'Api\LoginController@loginApi']);


//Auth::routes();

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::namespace('Api')->group(function() {
        Route::prefix('erros')->group(function() {
            Route::get('/', ['uses' => 'ErroController@index']);
            Route::get('/adicionar', ['uses' => 'ErroController@adicionar']);
            Route::post('/salvar', ['uses' => 'ErroController@store']);
            Route::get('/erros/{id}', ['uses' => 'ErroController@show']);
            Route::get('/editar/{id}', ['uses' => 'ErroController@editar']);
            Route::put('/atualizar/{id}', ['uses' => 'ErroController@atualizar']);
            Route::get('/deletar/{id}', ['uses' => 'ErroController@deletar']);
            Route::get('/detalhes/{id}', ['uses' => 'ErroController@detalhes']);
        });
    });
    Route::namespace('Auth')->group(function() {
        Route::prefix('user')->group(function() {
            Route::post('/cadastrar', ['uses' => 'RegisterController@registerUser']);
            Route::get('/lista', ['uses' => 'RegisterController@listUsers']);
            Route::get('/lista/{id}', ['uses' => 'RegisterController@listUser']);
            Route::put('/atualizar/{id}', ['uses' => 'RegisterController@updateUser']);
            Route::delete('/deletar/{id}', ['uses' => 'RegisterController@deleteUser']);
        });
    });
});

//Route::post('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
//Route::get('/register', ['uses' => 'Auth\RegisterController@showRegistrationForm']);






