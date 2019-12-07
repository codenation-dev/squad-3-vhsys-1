<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Erro;
use App\User;


class ErroController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        $registros = Erro::all();

        return view('admin.erros.index', compact('registros'), compact('usuarios'));
    }

    public function adicionar()
    {
        return view('admin.erros.adicionar');
    }

    public function salvar(Request $req)
    {
        //$validator = \Validator::make();

        $dados = $req->all();

        Erro::create($dados);
        return redirect()->route('admin.erros');
    }

    public function editar($id)
    {
        $registro = Erro::find($id);
        return view('admin.erros.editar', compact('registro'));
    }

    public function atualizar(Request $req, $id)
    {
        $dados = $req->all();


        Erro::find($id)->update($dados);
        return redirect()->route('admin.erros');
    }

    public function deletar($id) {
        Erro::find($id)->delete();
        return redirect()->route('admin.erros');
    }

}
