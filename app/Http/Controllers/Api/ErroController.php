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

  public function index()
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
  public function save(Request $request)
  {
    $data = $request->all();

    try{
      $data['usuario_id'] = auth('api')->user()->id;
      $data['usuario_name'] = auth('api')->user()->name;
      $data['status'] = 'Ativo';
      $data['data'] = date('Y-m-d');

      Erro::create($data);

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
  public function destroy($id) {
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
