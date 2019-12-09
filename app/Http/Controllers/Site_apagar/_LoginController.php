<?php

namespace App\Http\Controllers\Sites;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
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
            return redirect()->route('admin.erros');
        } else {
            return redirect()->route('login');
        }
    }

    public function sair()
    {
        Auth::logout();
        return redirect()->route('home.index');
    }

}
