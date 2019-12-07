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

    public function entrar(Request $req)
    {
        $dados = $req->all();
        if(Auth::attempt(['email'=>$dados['email'], 'password'=>$dados['password']])) {
            return redirect()->route('erros');
        } else {
            return redirect()->route('login');
        }
    }

        public function loginApi(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string',
        ])->validate();

        if(!$token = auth('api')->attempt($credentials)) {
            return response()->json(['Unauthorized' => 'Acesso não autorizado!'], 401);
        }

        return response()->json([
            'Msg:' => 'Login realizado com sucesso!',
            'token' => $token
        ], 201);
    }

    public function sair(Request $request)
    {
        Auth::logout();
        return redirect()->route('home.index');
    }

}
