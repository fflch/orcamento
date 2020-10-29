<div class="form-group">
    <label for="tipoconta">Tipo De Conta</label>

    <select class="form-control" name="tipoconta_id" >
        <option value="{{ $conta->tipoconta_id ?? old('tipoconta_id') }}">{{ $conta->tipoconta->descricao ?? old('tipoconta_descricao') }}</option>
        <option value=null>----------</option>
        @foreach($lista_tipos_contas as $lista_tipo_conta)
            <option value="{{ $lista_tipo_conta->id }}">{{ $lista_tipo_conta->descricao }}</option>
        @endforeach

</select>
</div>

<div class="form-group">
    <label for="area">Área</label>

    <select class="form-control" name="area_id" >
        <option value="{{ $conta->area_id ?? old('area_id') }}">{{ $conta->area->nome ?? old('area_nome') }}</option>
        <option value=null>----------</option>
        @foreach($lista_areas as $lista_area)
            <option value="{{ $lista_area->id }}">{{ $lista_area->nome }}</option>
        @endforeach

</select>
</div>

<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $conta->nome ?? old('nome') }}" placeholder="Ex: Orçamento">
</div>
<div class="form-group">
    <label for="email">E-mail</label>
    <input type="text" class="form-control" name="email" value="{{ $conta->email ?? old('email') }}" placeholder="Ex: teste1@usp.br">
</div>
<div class="form-group">
    <label for="numero">Número</label>
    <input type="text" class="form-control" name="numero" value="{{ $conta->numero ?? old('numero') }}" placeholder="Ex: 1">
</div>
<div class="form-group">
    <label class="checkbox-inline"><input type="checkbox" name="ativo" value="1" 
        @if (isset($conta->id) and ($conta->ativo === 1))
             checked
        @endif >
        <label for="ativo"> Ativo</label></label>
</div>
<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</div>