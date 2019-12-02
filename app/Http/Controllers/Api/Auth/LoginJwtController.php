<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{
    public function login(Request $request)
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

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'Msg:' => 'Logout realizado!'], 200);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json([
            'Msg:' => 'Token atualizado!',
            'token' => $token
        ], 200);
    }
}
