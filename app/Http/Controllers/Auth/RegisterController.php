<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/api/erros';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function registerUser(Request $request)
    {
        $dados = $request->all(['name', 'password', 'email']);

        if (User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'password' => Hash::make($dados['password']),])) {
            return response()->json([
                'status' => 'OK',
                'Message' => 'Usuário registrado com sucesso!'], 201);
        }
    }

  public function register(Request $request)
  {
    $dados = $request->all(['name', 'password', 'email']);

    if (User::create([
      'name' => $dados['name'],
      'email' => $dados['email'],
      'password' => Hash::make($dados['password']),])) {

      return redirect()->route('erros');
    }
  }

    public function listUsers()
    {
        return response()->json([
            'status' => 'OK',
            'Message' => User::get()], 201);
    }

    public function listUser($id)
    {
        $user = User::find($id);

        if($user) {
            return response()->json([
                'status' => 'OK',
                'Message' => $user], 201);
        } else {
            return response()->json(['data' => ['msg' => 'Usuário não existe!']]);
        }
    }

    public function updateUser($id, Request $request)
    {
        $dados = $request->all(['name', 'password', 'email']);
        $user = User::where('id', $id)->first();
        $user->name = $dados['name'];
        $user->email = $dados['email'];
        $user->password = Hash::make($dados['password']);
        if ($user->save()) {
            return response()->json([
                'status' => 'OK',
                'Message' => 'Usuário atualizado com sucesso!'], 201);
        }
        return response()->json([
            'status' => 'ERROR',
            'Message' => 'Error Registering'
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = $this->user->find($id);

        if ($user) {
            $user->delete();
            return response()->json([
                'status' => 'OK',
                'Message' => 'Usuário deletado com sucesso!'], 201);
        } else {
            return response()->json(['data' => ['msg' => 'Usuário não existe!']]);
        }
    }
}
