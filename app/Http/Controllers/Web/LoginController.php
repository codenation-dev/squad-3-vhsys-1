<?php

namespace App\Http\Controllers\Web;

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

  public function login(Request $request)
  {
    $dados = $request->all(['email', 'password']);
    if(!$token = Auth::attempt(['email'=>$dados['email'], 'password'=>$dados['password']])) {
      return redirect()->route('login');
    }

    return redirect()->route('erros');
  }

  public function logout()
  {
    auth('web')->logout();
    return redirect()->route('home.index');
  }

}
