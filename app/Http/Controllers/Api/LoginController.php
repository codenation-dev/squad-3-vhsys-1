<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function index()
  {
    return view('login.index');
  }

  /**
   * Login a user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function login(Request $request)
  {
    $credentials = $request->all(['email', 'password']);

    Validator::make($credentials, [
        'email' => 'required|string',
        'password' => 'required|string',
    ])->validate();

    if(!$token = auth('api')->attempt($credentials)) {
        return response()->json(['Unauthorized' => 'Acesso não autorizados!'], 401);
    }

    return response()->json([
        'Msg' => 'Login realizado com sucesso!',
        'token' => $token
    ], 201);
  }

  /**
   * Logout a user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    if(auth('api')->guest()) {
      return response()->json([
        'Msg' => 'Usuário não está logado!'
      ], 201);
    }

    auth('api')->logout();
    return response()->json([
      'Msg' => 'Logout realizado com sucesso!'
    ], 201);
  }
}
