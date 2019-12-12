
@extends('layouts.site')

@section('title', 'Central de Erros - Logs')

@section('content')

<script language="javascript">
  function submitform()
  {
    document.forms["sp2"].submit();
  }

  function setInputValue(input_id, val) {
    document.getElementById(input_id).setAttribute('name', val);
  }

  function Selecionado() {
    var x = document.getElementById("busca").value;
    setInputValue('search', x);
}

</script>

  <div class="container">
    <div class="position-ref full-height">
      <div class="content">
        <div class="mt-3 left-align blue-grey darken-2" style="border-radius: 6px; color: #fff; padding: 12px;">
          <h5 style="font-size: 1.8vw" class="welcome">Bem vindo(a) {{ Auth::user()->name }} </h5>
          {{--<p style="font-size: 1vw; word-break: break-word;">Seu token é: {{$token}}</p>--}}
        </div>
        
        <form name=sp2 action="{{ route('erros') }}" method="get">


        <div class="row">
          <div class="input-field col m6 s12 l3">
            <select name="ambiente">
              <option selected disabled>Ambiente:</option>
              <option value="1">Produção</option>
              <option value="2">Homologação</option>
              <option value="3">Desenvolvimento</option>
            </select>
          </div>
          <div class="input-field col m6 s12 l3">
            <select name="order">
              <option selected disabled>Ordenar por:</option>
              <option value="1">Nível</option>
              <option value="2">Frequência</option>
            </select>
          </div>
          <div class="input-field col m6 s12 l3">
            <select id="busca" onchange="Selecionado()">
              <option selected disabled>Buscar por:</option>
              <option value="nivel">Nível</option>
              <option value="descricao">Descrição</option>
              <option value="origem">Origem</option>
            </select>
          </div>
          <div class="input-field col m5 s10 l2">
            <input id="search" type="search">
            <label for="search">Buscar</label>
          </div>
          <div class="input-field col m1 s2 l1" style="padding: 0 !important;">
            <i class="medium material-icons" style="cursor: pointer" onClick="submitform()">search</i>
          </div>
        </form>
        <div>
          <table  class="centered responsive-table">
            <thead>
              <tr>
                <th class="center-align">#</th>
                <th class="center-align ">Nível</th>
                <th class="center-align">Descrição do log</th>
                <th class="center-align">Eventos</th>
                <th class="center-align">Origem</th>
                <th class="center-align">Status</th>
                <th class="center-align">Usuário</th>
                @if(Auth::user()->admin == 1)
                    <th class="center-align">Ação</th>
                @endif
              </tr>
            </thead>
              <tbody>

                @foreach($registros as $registro)
                  @if((Auth::user()->id == $registro->usuario_id || Auth::user()->admin == 1) && $registro->status === 'Ativo')

                  <tr>
                    <td>{{$registro->id}}</td>
                    <td><span class="span-erro {{strtolower($registro->nivel)}}">{{$registro->nivel}}</span></td>
                    <td style="max-width: 540px;">
                      <p>{{mb_substr($registro->descricao, 0, 40)}}{{(mb_strlen($registro->descricao) >= 40 ? '... ' : '')}}</p>
                      <p class="center-align log-origin">{{$registro->origem}} </p>
                      <p class="center-align log-title">{{$registro->titulo}} <br/>{{$registro->created_at}} </p>
                      <a class="modal-trigger" href="{{ route('erros.detalhes', $registro->id) }}">+ Detalhes</a>
                    </td>
                    <td>{{$registro->eventos}}</td>
                    <td>{{$registro->origem}}</td>
                    <td><span class="span-status {{strtolower($registro->status)}}">{{mb_convert_case($registro->status , MB_CASE_TITLE)}}</span></td>
                    <td>{{$registro->usuario_name}}</td>

                    @if(Auth::user()->admin == 1)
                      <td>
                        <a class="btn blue-grey lighten-1" style="margin-bottom:5px; font-size: .70rem;" onclick="return confirm('Você realmente deseja arquivar esse log?')" href="{{ route('erros.editar', $registro->id) }}"><i class="left material-icons">archive</i> Arquivar</a>
                        <a class="btn blue-grey darken-3" style="margin-bottom:5px; font-size: .70rem;" onclick="return confirm('Você realmente deseja deletar esse log?')" href="{{ route('erros.deletar', $registro->id) }}"><i class="left large material-icons">delete</i> Deletar</a>
                      </td>
                    @endif
                  </tr>
                    @endif
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
