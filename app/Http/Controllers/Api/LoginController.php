<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

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

    public function sair(Request $request)
    {
        Auth::logout();
        return redirect()->route('home.index');
    }

}
