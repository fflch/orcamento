<div class="form-group">
    <label for="tipoconta">Tipo De Conta</label>
    <select class="form-control" name="tipoconta_id" >
        <option value="{{ $nota->tipoconta_id ?? old('tipoconta_id') }}">{{ $nota->tipoconta->descricao ?? old('tipoconta_descricao') }}</option>
        <option value=null>----------</option>
        @foreach($lista_tipos_contas as $lista_tipo_conta)
            <option value="{{ $lista_tipo_conta->id }}">{{ $lista_tipo_conta->descricao }}</option>
        @endforeach

</select>
</div>
<div class="form-group">
    <label for="texto">Texto</label>
    <input type="text" class="form-control" name="texto" value="{{ $nota->texto ?? old('texto') }}" placeholder="Ex: Suplementação">
</div>
<div class="form-group">
    <label for="Tipo">Tipo</label>
    <select class="form-control" name="tipo" >
        <option value="{{ $nota->tipo ?? old('tipo') }}">{{ $nota->tipo ?? old('tipo') }}</option>
        <option value=null>----------</option>
        <option value='Descrição'>Descrição</option>
        <option value='Observação'>Observação</option>
    </select>
</div>

<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</div>