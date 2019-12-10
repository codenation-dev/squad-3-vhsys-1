
@extends('layouts.site')

@section('title', 'Central de Erros - Home')

@section('content')
  <div class="container">
    <div class="position-ref full-height">
      <div class="content">
        <div class="mt-3 left-align blue-grey darken-2" style="border-radius: 6px; color: #fff; padding: 12px;">
          <h5 style="font-size: 1.8vw">Bem vindo(a) {{ Auth::user()->name }} </h5>
          {{--<p style="font-size: 1vw; word-break: break-word;">Seu token é: {{$token}}</p>--}}
        </div>

        <div class="row">
          <div class="input-field col m6 s12 l3">
            <select name="ambiente">
              <option selected>Produção</option>
              <option>Homologação</option>
              <option>Dev</option>
            </select>
          </div>
          <div class="input-field col m6 s12 l3">
            <select name="order">
              <option selected disabled>Ordenar por:</option>
              <option>Nível</option>
              <option>Frequência</option>
            </select>
          </div>
          <div class="input-field col m6 s12 l3">
            <select name="busca">
              <option selected disabled>Buscar por:</option>
              <option>Nível</option>
              <option>Descrição</option>
              <option>Origem</option>
            </select>
          </div>
          <div class="input-field col m6 s12 l3">
            <input id="search" type="search">
            <label for="search">Procurar</label>
            <i class="material-icons"  onclick="alert('oi')">search</i>
          </div>
        </div>

        <div>
          <table  class="centered responsive-table">
            <thead>
              <tr>
                <th class="center-align">#</th>
                <th class="center-align ">Nível</th>
                <th class="center-align">Descrição do log</th>
                <th class="center-align">Eventos</th>
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
                      <p class="center-align">{{$registro->titulo}} <br/>{{$registro->created_at}} </p>
                      <p>{{mb_substr($registro->descricao, 0, 80)}}{{(mb_strlen($registro->descricao) >= 80 ? '... ' : '')}}</p>
                      <a class="modal-trigger" href="{{ route('erros.detalhes', $registro->id) }}">+ Detalhes</a>
                    </td>
                    <td>{{$registro->eventos}}</td>
                    <td><span class="span-status {{strtolower($registro->status)}}">{{mb_convert_case($registro->status , MB_CASE_TITLE)}}</span></td>
                    <td>{{$registro->usuario_name}}</td>

                    @if(Auth::user()->admin == 1)
                      <td>
                        <a class="btn blue-grey lighten-1" style="margin-bottom:5px; font-size: .60rem;" onclick="return confirm('Você realmente deseja arquivar esse log?')" href="{{ route('erros.editar', $registro->id) }}">Arquivar</a>
                        <a class="btn blue-grey darken-3" style="margin-bottom:5px; font-size: .60rem;" onclick="return confirm('Você realmente deseja deletar esse log?')" href="{{ route('erros.deletar', $registro->id) }}">Deletar</a>
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
