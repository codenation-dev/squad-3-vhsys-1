<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/login', ['uses' => 'Api\LoginController@login']);
Route::get('/logout', ['uses' => 'Api\LoginController@logout']);

Route::group(['middleware' => 'jwt.auth'], function () {
  Route::namespace('Api')->group(function() {
    Route::prefix('erros')->group(function() {
      Route::get('/', ['uses' => 'ErroController@index']);
      Route::get('/{id}', ['uses' => 'ErroController@show']);
      Route::post('/cadastrar', ['uses' => 'ErroController@save']);
      Route::patch('/arquivar/{id}', ['uses' => 'ErroController@store']);
      Route::delete('/deletar/{id}', ['uses' => 'ErroController@destroy']);
    });

    Route::prefix('users')->group(function() {
      Route::get('/', ['uses' => 'UserController@index']);
      Route::get('/{id}', ['uses' => 'UserController@show']);
      Route::post('/cadastrar', ['uses' => 'UserController@save']);
      Route::patch('/atualizar/{id}', ['uses' => 'UserController@update']);
      Route::delete('/deletar/{id}', ['uses' => 'UserController@destroy']);
    });
  });
});






