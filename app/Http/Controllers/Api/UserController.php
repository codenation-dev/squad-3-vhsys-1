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
      $users = auth('api')->user();

      return response()->json($users->get(), 200 );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
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
                    'msg' => 'Usuário ' . $data['name'] . ' cadastrado com sucesso!'
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
                'Erro' => 'Usuário de ID ' . $id . ' não encontrado!'
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
    public function update($id)
    {
        try{
            $user = $this->user->findOrFail($id);
            $user->admin = ($user->admin === 0 ? 1 : 0);
              $user->update();

              return response()->json([
                'data' => [
                  'msg' => 'Permissão de acesso atualizada com sucesso!',
                  'Obs' => 'O usuário ' . $user->name . ($user->admin === 1 ? ' tem permissões de administrador!' : ' não tem permissões de administrador!')
                ]
              ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Usuário de ID ' . $id . ' não encontrado ou erro ao atualizar usuário!',
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
                    'Erro' => 'Usuário de ID ' . $id . ' é administrador, não pode ser excluído!'
                ], 401);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Usuário de ID ' . $id . ' removido com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Usuário de ID ' . $id . ' não encontrado!'
            ], 404);
        }
    }
}
