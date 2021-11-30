<div class="form-row">
<div class="form-group col-md-6">
    <label for="tipoconta">Tipo De Conta</label>
        <select class="tipocontas_select form-control" name="tipoconta_id" tabindex="1">
            <option value=" ">&nbsp;</option>
            @foreach($lista_tipos_contas as $lista_tipo_conta)
                <option value="{{ $lista_tipo_conta->id }}" @if(old('conta_id') == $lista_tipo_conta->id) {{'selected'}}
                    @else {{($conta->tipoconta_id === $lista_tipo_conta->id ) ? 'selected' : ''}} @endif>
                    {{ $lista_tipo_conta->descricao }}
                </option>
            @endforeach
        </select>
        
</div>

<div class="form-group col-md-6">
    <label for="area">Área</label>
        <select class="areas_select form-control" name="area_id" tabindex="1">
            <option value=" ">&nbsp;</option>
            @foreach($lista_areas as $lista_area)
                <option value="{{ $lista_tipo_conta->id }}" @if(old('conta_id') == $lista_area->id) {{'selected'}}
                    @else {{($conta->area_id === $lista_area->id ) ? 'selected' : ''}} @endif>
                    {{ $lista_area->nome }}
                </option>
            @endforeach
        </select>

</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $conta->nome ?? old('nome') }}" placeholder="[ Ex: Orçamento ]" tabindex="3">
</div>
<div class="form-group col-md-4">
    <label for="email">E-mail</label>
    <input type="text" class="form-control" name="email" value="{{ $conta->email ?? old('email') }}" placeholder="[ Ex: nome.sobrenome@usp.br ]" tabindex="4">
</div>
<div class="form-group col-md-1">
    <label for="numero">Número</label>
    <input type="text" class="form-control" name="numero" value="{{ $conta->numero ?? old('numero') }}" placeholder="[ Ex: 1 ]" tabindex="5">
</div>
<div class="form-group col-md-1">
    <label class="checkbox-inline" for="ativo">Ativo<br>
    <input type="checkbox" id="ativo" name="ativo" value="1" tabindex="6"
        @if (isset($conta->id) and ($conta->ativo === 1))
             checked
        @endif >
        </label>    
</div>
</div>

<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar" tabindex="7">
                <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="8">
            </div>
        </div>
    </div>
</div>
