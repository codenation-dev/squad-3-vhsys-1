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

Route::post('/login', ['uses' => 'Api\LoginController@login'])->name('api.login');
Route::get('/logout', ['uses' => 'Api\LoginController@logout'])->name('api.logout');


Route::group(['middleware' => 'jwt.auth'], function () {
  Route::namespace('Api')->group(function() {
    Route::prefix('erros')->group(function() {
      Route::get('/', ['uses' => 'ErroController@index'])->name('erros.index');
      Route::get('/{id}', ['uses' => 'ErroController@show'])->name('erros.show');
      Route::post('/cadastrar', ['uses' => 'ErroController@save'])->name('erros.save');
      Route::patch('/arquivar/{id}', ['uses' => 'ErroController@store'])->name('erros.store');
      Route::delete('/deletar/{id}', ['uses' => 'ErroController@destroy'])->name('erros.destroy');
    });

    Route::prefix('users')->group(function() {
      Route::get('/', ['uses' => 'UserController@index'])->name('user.index');
      Route::get('/{id}', ['uses' => 'UserController@show'])->name('user.show');
      Route::post('/cadastrar', ['uses' => 'UserController@save'])->name('user.save');
      Route::patch('/atualizar/{id}', ['uses' => 'UserController@update'])->name('user.update');
      Route::delete('/deletar/{id}', ['uses' => 'UserController@destroy'])->name('user.destroy');
    });
  });
});






