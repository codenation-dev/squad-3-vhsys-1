<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Erro;
use App\User;


class ErroController extends Controller
{
    static function index()
    {
      $usuarios = User::all();
      $registros = Erro::all();

      if(auth()->user()) {
        return view('erros.index', compact('registros'), compact('usuarios'));
      }
    }

    public function adicionar()
    {
        return view('erros.adicionar');
    }

    public function salvar(Request $req)
    {

        $dados = $req->all();

        Erro::create($dados);
        return redirect()->route('erros');
    }

    public function arquivar($id)
    {
        $erro = Erro::find($id);
        $erro->status = 'Concluido';
        $erro->update();
        return redirect()->route('erros');
    }

    public function atualizar(Request $req, $id)
    {
        $dados = $req->all();


        Erro::find($id)->update($dados);
            return redirect()->route('erros');
    }

    public function deletar($id) {
        Erro::find($id)->delete();
        return redirect()->route('erros');
    }

    public function detalhes($id)
    {
        $usuarios = User::all();
        $registros = Erro::find($id);

        return view('erros.detalhes', compact('registros'), compact('usuarios'));
    }


}
