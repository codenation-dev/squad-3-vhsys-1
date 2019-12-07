<?php

namespace App\Http\Controllers\Api;

use App\Erro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

const SEARCH_FOR_LEVEL = "1";
const SEARCH_FOR_DESCRIPTION = "2";
const SEARCH_FOR_ORIGIN = "2";

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

    /*
    protected function storeOrUpdate(Request $request, $id = NULL) 
    {
        $data = $request->all();
        //sore
        
        if ($id == NULL)
        {
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
                    'Msg' => 'Verifique os dados e tente novamente!' . $e->getMessage()
                ], 400);
            }
        }

        //update     
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
    */

    public function index(Request $request)
    {
        $userId         = auth('api')->user()->id;
        $ambience       = $request->get('ambiente');
        $ordination     = $request->get('ordenacao');
        $search         = $request->get('busca');
        $searchParam    = $request->get('chave');

        $filters = [
            ['status',      '=',    'ativo'],
            ['usuario_id',  '=',    $userId]];

        if ($ambience !== null)
            array_push($filters, ["ambiente", '=', $ambience]);


        if ($search !== null){
            if ($search === SEARCH_FOR_LEVEL)
                array_push($filters, ["nivel", '=', $searchParam]);

            if ($search === SEARCH_FOR_DESCRIPTION)
                array_push($filters, ["titulo", '=', $searchParam]);
                
            if ($search === SEARCH_FOR_ORIGIN)
                array_push($filters, ["origem", '=', $searchParam]);                
        }

        $order = "data";
        if ($ordination === "1")
            $order = "nivel";
   
        $erros = Erro::where($filters)
            ->orderBy($order, 'asc');

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
       // $this->storeOrUpdate($request);
    
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
                'Msg' => 'Verifique os dados e tente novamente!' . $e->getMessage()
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
        //$this->storeOrUpdate($request, $id);

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
