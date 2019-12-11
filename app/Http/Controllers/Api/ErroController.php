<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Erro;

class ErroController extends Controller
{
  /**
   * @var Erro
   */
  private $erro;

  public function __construct(Erro $erro)
  {
    $this->erro = $erro;
    $this->middleware('jwt.auth');
  }

  private function ObterIdFrequencia($data): string
  {
    $strFreq = '';
    if ($data['titulo'] !== null) 
      $strFreq .= $data['titulo'];
    
    if ($data['descricao'] !== null) 
      $strFreq .= $data['descricao'];            

    if ($data['nivel'] !== null) 
      $strFreq .= $data['nivel'];            

    if ($data['ambiente'] !== null) 
      $strFreq .= $data['ambiente'];                        

    if ($data['origem'] !== null) 
      $strFreq .= $data['origem'];             

    if ($data['data'] !== null) 
      $strFreq .= $data['data']; 

    if ($data['usuario_id'] !== null)
      $strFreq .= $data['usuario_id'];   

    return md5($strFreq);
  }

  public function index(Request $request)
  {    
    $userId  = auth('api')->user()->id;

    $ambiente   = $request->get('ambiente');
    $ordenacao  = $request->get('order');
    $nivel      = $request->get('nivel');
    $descricao  = $request->get('descricao');
    $origem     = $request->get('origem');

    $filters = [
      ['status', '=', 'ativo']
    ];

    if ($usuarios ->admin != 1)
      array_push($filters, ["usuario_id", '=', $usuarios->id]);        

      $order = 'eventos';
      $direcao = 'desc';
      if ($ordenacao !== null)
      {
        if ($ordenacao === '1')
        {
          $order = 'nivel';
          $direcao = 'asc';
        }
      }

    if ($nivel !== null)
        array_push($filters, ["nivel", 'LIKE', '%'.$nivel.'%']);

    if ($descricao !== null)
        array_push($filters, ["titulo", 'LIKE', '%'.$descricao.'%']);
        
    if ($origem !== null)
        array_push($filters, ["origem", 'LIKE', '%'.$origem.'%']);


    $erros = Erro::where($filters)
      ->orderBy($order, $direcao);
    

    return response()->json($erros->get(), 200 );
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

    try
    {
      $data['usuario_id'] = auth('api')->user()->id;
      $data['data'] = date('Y-m-d'); 

      $idFrequencia = $this->ObterIdFrequencia($data);  

      $erro = Erro::where([
        ['status', '=', 'Ativo'],
        ['id_frequencia', '=', $idFrequencia]]
      )->first();

      if ($erro === null)
      {
        $data['usuario_name'] = auth('api')->user()->name;
        $data['status'] = 'Ativo';             
        $data['id_frequencia'] = $idFrequencia;
        $data['eventos'] = 1;

        Erro::create($data);

        return response()->json([
            'msg' => 'Log de Erro cadastrado com sucesso!'
        ], 200);
      }
      else
      {
        $erro->eventos += 1;
        $erro->update();
      
        return response()->json([
          'msg' => 'Log de Erro atualizado com sucesso!'
        ], 200);
      }

    } catch (\Exception $e) {
      return response()->json( [
          'Erro' => 'Não foi possível cadastrar o log de erro.',
          'Msg' => 'Verifique os dados e tente novamente!',
          'Exp' => $e->getMessage()
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
      $erro = auth('api')->user()->erros()->findOrFail($id);
      return response()->json([
          'data' => $erro
      ], 200);

    } catch (\Exception $e) {
      return response()->json(['Erro' => 'Log com ID ' . $id . ' não existe ou pertence a outro usuário!'
      ], 404);
    }
  }

  /**
   * Change status of the specified resource to Concluded.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function store($id)
  {
    try{
      $erro = auth('api')->user()->erros()->findOrFail($id);
      if ($erro->status === 'Ativo') {
        $erro->status = 'Concluido';
        $erro->update();

        return response()->json([
            'msg' => 'Log de ID ' . $id  . ' arquivado com sucesso!'
        ], 200);
      } else {
        return response()->json([
            'msg' => 'Log de ID ' . $id  . ' já está arquivado!'
        ], 400);
      }

    } catch (\Exception $e) {
      return response()->json( [
        'Erro' => 'Não foi possível arquivar o log de ID ' . $id . '!',
        'Msg' => 'Verifique o ID passado e novamente!'
      ], 400);
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
    try {
      $erro = auth('api')->user()->erros()->findOrFail($id);
      $erro->delete();
      return response()->json([
          'msg' => 'Log de ID ' . $id  . ' excluído com sucesso!'
      ], 400);
    } catch (\Exception $e) {
      return response()->json( [
          'Erro' => 'Não foi possível excluir o log de ID ' . $id  . '.',
          'Msg' => 'Verifique o ID passado e novamente!'
      ], 400);
    }
  }

}
