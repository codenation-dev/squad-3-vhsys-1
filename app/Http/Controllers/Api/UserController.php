<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(10);

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if(!$request->has('password') || !$request->get('password')) {
            return response()->json([
                'Erro' => 'É necessário informar uma senha!'
            ], 400);
        }

        try{
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);

            return response()->json([
                    'msg' => 'Usuário cadastrado com sucesso!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json( [
                'Erro' => 'Erro ao cadastrar o usuário, verifique os dados e tente novamente!',
                'Msg' => 'Talvez o email informado já esteja cadastrado!'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $user = $this->user->findOrFail($id);

            return response()->json([
               'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Usuário não encontrado!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($request->has('password') && $request->get('password')) {

            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try{
            $user = $this->user->findOrFail($id);
            $user->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário atualizado com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Usuário não encontrado ou erro ao atualizar usuário!',
                'Msg' => 'Verifique os dados e tente novamente!'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = $this->user->findOrFail($id);
            if($user['admin'] === 0) {
                $user->delete();
            } else {
                return response()->json([
                    'Erro' => 'Usuário é administrador, não pode ser excluído!'
                ], 401);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Usuário removido com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Usuário não encontrado!'
            ], 404);
        }
    }
}
