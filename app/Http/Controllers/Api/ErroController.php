<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Erro;
use App\User;


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

    public function index(Request $request)
    {
        $erros = auth('api')->user()->erros();

        return response()->json($erros->get(), 200 );
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

            Erro::create($data);

            return response()->json([
                'msg' => 'Log de Erro cadastrado com sucesso!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json( [
                'Erro' => 'Não foi possível cadastrar o log de erro.' . $e->getMessage(),
                'Msg' => 'Verifique os dados e tente novamente!'
            ], 400);
        }
    }

    public function arquivar($id)
    {
        $erro = Erro::find($id);
        $erro->status = 'Concluido';
        $erro->update();
    }

    public function deletar($id) {
        Erro::find($id)->delete();
        return redirect()->route('erros');
    }

}
