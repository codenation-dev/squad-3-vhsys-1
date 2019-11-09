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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function() {

    //Rota para login
    Route::post('login', 'Auth\\LoginJwtController@login')->name('login');
    Route::get('logout', 'Auth\\LoginJwtController@logout')->name('logout');
    Route::get('refresh', 'Auth\\LoginJwtController@refresh')->name('refresh');


    Route::group(['middleware' => ['jwt.auth']], function (){

        //Rotas para os Logs de Erros
        Route::name('erros.')->group(function() {
            Route::resource('erros', 'ErroController');
        });


        // Rotas para os usuários
        Route::name('users.')->prefix('users')->group(function() {
            Route::resource('/', 'UserController');

        });
    });


});


