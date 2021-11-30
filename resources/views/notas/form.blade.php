<div class="form-row">
<div class="form-group col-md-6">
    <label for="tipoconta">Tipo De Conta</label>
    <select class="tipocontas_select form-control" name="tipoconta_id" tabindex="1">
            <option value=" ">&nbsp;</option>
            @foreach($lista_tipos_contas as $lista_tipo_conta)
                <option value="{{ $lista_tipo_conta->id }}" @if(old('conta_id') == $lista_tipo_conta->id) {{'selected'}}
                    @else {{($nota->tipoconta_id === $lista_tipo_conta->id ) ? 'selected' : ''}} @endif>
                    {{ $lista_tipo_conta->descricao }}
                </option>
            @endforeach
        </select>

</div>
<div class="form-group col-md-6">
    <label for="Tipo">Tipo</label>
    <select class="form-control" name="tipo" tabindex="2">
        <option value="{{ $nota->tipo ?? old('tipo') }}">{{ $nota->tipo ?? old('tipo') }}</option>
        <option value=null>----------</option>
    @foreach($lista_tipos as $lista_tipo)
    <option value="{{ $lista_tipo ?? old('tipo') }}">{{ $lista_tipo ?? old('tipo') }}</option>
    @endforeach
    </select>
</div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="texto">Texto</label>
        <input type="text" class="form-control" name="texto" value="{{ $nota->texto ?? old('texto') }}" placeholder="[ Ex: Suplementação de Cursos ]" tabindex="3">
    </div>
</div>

<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar" tabindex="4">
                <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="5">
            </div>
        </div>
    </div>
</div>
