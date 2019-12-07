<div class="input-field">
    <input type="text" name="titulo" required value="{{ isset($registro->titulo) ? $registro->titulo : '' }}">
    <label>Título</label>
</div>

<div class="input-field">
    <input type="text" name="descricao" class="materialize-textarea" required value="{{ isset($registro->descricao) ? $registro->descricao : '' }}">
    <label for="descricao">Descrição</label>
</div>

<div class="row">
    <div class="input-field @if(Auth::user()->admin == 1) col l3 m6 s12 @else == col l4 @endif">
        <input type="number" name="eventos" required value="{{ isset($registro->eventos) ? $registro->eventos : '' }}">
        <label>Eventos</label>
    </div>

    <div class="input-field @if(Auth::user()->admin == 1) col l3 m6 s12 @else == col l4 @endif">
        <select name="nivel" required value="{{ isset($registro->nivel) ? $registro->nivel : '' }}">
            <option value="" disabled></option>
            <option selected>Debug</option>
            <option>Error</option>
            <option>Warning</option>
        </select>
        <label>Nível</label>
    </div>

    <div class="input-field @if(Auth::user()->admin == 1) col l3 m6 s12 @else == col l4 @endif">
        <input type="text" required name="data" value="{{ date('Y-m-d H:i:s')}}">
        <label>Data</label>
    </div>
    @if(Auth::user()->admin == 1)
    <div class="input-field col l3 m6 s12">
        <select name="status" required value="{{ isset($registro->status) ? $registro->status : '' }}">
            <option value="" disabled></option>
            <option selected>Ativo</option>
            <option>Concluido</option>
        </select>
        <label>Status</label>
    </div>
    @endif
</div>

<div class="input-field">
    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id}}">
    <input type="hidden" name="usuario_name" value="{{ Auth::user()->name}}">
    {{--<label>Usuário ID</label>--}}
</div>



