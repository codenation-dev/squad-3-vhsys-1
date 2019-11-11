<?php

namespace App\Http\Controllers\Api;

use App\Erro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErroController extends Controller
{
    /**
     * @var Erro
     */
    private $erro;

    public function __construct(Erro $erro)
    {

        $this->erro = $erro;
    }

    public function index()
    {
        $erros = auth('api')->user()->erro();

        return response()->json($erros->paginate(10), 200 );
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

        try{

            $data['usuario_id'] = auth('api')->user()->id;
            $data['usuario_name'] = auth('api')->user()->name;
            $data['status'] = 'ativo';
            $data['data'] = date('Y-m-d');

            $erro = $this->erro->create($data);

            return response()->json([
                'msg' => 'Log de Erro cadastrado com sucesso!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json( [
                'Erro' => 'Não foi possível cadastrar o log de erro.',
                'Msg' => 'Verifique os dados e tente novamente!'
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
            $erro = auth('api')->user()->erro()->findOrFail($id);

            return response()->json([
                'data' => $erro
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['Erro' => 'Log não existe ou pertence a outro usuário!'
            ], 400);
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

        try{
            $erro = auth('api')->user()->erro()->findOrFail($id);
            $erro->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Log atualizado com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Erro ao atualizar: Log não existe ou pertence a outro usuário!',
                'Msg' => 'Verifique os dados e tente novamente!'
            ], 400);
        }
    }

    public function destroy($id)
    {
        try{
            $erro = auth('api')->user()->erro()->findOrFail($id);
            $erro->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Log removido com sucesso!'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'Erro' => 'Log não encontrado ou pertence a outro usuário!'
            ], 400);

        }
    }
}
