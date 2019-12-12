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
Route::post('/login/entrar', ['as' => 'login.entrar', 'uses' => 'Web\LoginController@login']);
Route::get('/logout', ['as' => 'login.sair', 'uses' => 'Web\LoginController@logout']);

Route::group(['middleware' => 'auth'], function () {
  Route::namespace('Web')->group(function() {
    Route::prefix('erros')->group(function() {
      Route::get('/', ['as' => 'erros', 'uses' => 'ErroController@index']);
      Route::get('/arquivar/{id}', ['as' => 'erros.editar', 'uses' => 'ErroController@arquivar']);
      Route::get('/deletar/{id}', ['as' => 'erros.deletar', 'uses' => 'ErroController@deletar']);
      Route::get('/detalhes/{id}', ['as' => 'erros.detalhes', 'uses' => 'ErroController@detalhes']);
    });
  });
});

Auth::routes();

