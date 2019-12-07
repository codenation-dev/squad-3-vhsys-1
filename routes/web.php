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


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);
Route::get('/login', ['as' => 'login', 'uses' => 'Api\LoginController@index']);
Route::post('/login/entrar', ['as' => 'login.entrar', 'uses' => 'Api\LoginController@entrar']);
Route::get('/login/sair', ['as' => 'login.sair', 'uses' => 'Api\LoginController@sair']);

Route::post('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
Route::get('/register', ['uses' => 'Auth\RegisterController@showRegistrationForm']);

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::namespace('Web')->group(function() {
        Route::prefix('erros')->group(function() {
            Route::get('/', ['as' => 'erros', 'uses' => 'ErroController@index']);
            Route::get('/adicionar', ['as' => 'erros.adicionar', 'uses' => 'ErroController@adicionar']);
            Route::post('/salvar', ['as' => 'erros.salvar', 'uses' => 'ErroController@salvar']);
            Route::get('/editar/{id}', ['as' => 'erros.editar', 'uses' => 'ErroController@editar']);
            Route::put('/atualizar/{id}', ['as' => 'erros.atualizar', 'uses' => 'ErroController@atualizar']);
            Route::get('/deletar/{id}', ['as' => 'erros.deletar', 'uses' => 'ErroController@deletar']);
            Route::get('/detalhes/{id}', ['as' => 'erros.detalhes', 'uses' => 'ErroController@detalhes']);
        });
    });
    Route::namespace('Auth')->group(function() {
        Route::prefix('api/user')->group(function() {
            Route::post('/cadastrar', ['uses' => 'RegisterController@registerUser']);
            Route::get('/lista', ['uses' => 'RegisterController@listUsers']);
            Route::get('/lista/{id}', ['uses' => 'RegisterController@listUser']);
            Route::put('/atualizar/{id}', ['uses' => 'RegisterController@updateUser']);
            Route::delete('/deletar/{id}', ['uses' => 'RegisterController@deleteUser']);
        });
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
