<div class="form-row">
<div class="form-group col-md-6">
    <label for="tipoconta">Tipo De Conta</label>

    <input list="tipocontas" name="tipoconta_id" id="tipoconta_id" class="form-control" value="{{ $conta->tipoconta_id ?? old('tipoconta_id') }}">
        <datalist id="tipocontas">
            @foreach($lista_tipos_contas as $lista_tipo_conta)
                <option value="{{ $lista_tipo_conta->id }}">{{ $lista_tipo_conta->descricao }}
            @endforeach
        </datalist>

</div>

<div class="form-group col-md-6">
    <label for="area">Área</label>

    <input list="areas" name="area_id" id="area_id" class="form-control" value="{{ $conta->area_id ?? old('area_id') }}">
        <datalist id="areas">
            @foreach($lista_areas as $lista_area)
                <option value="{{ $lista_area->id }}">{{ $lista_area->nome }}
            @endforeach
        </datalist>

</div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $conta->nome ?? old('nome') }}" placeholder="[ Ex: Orçamento ]">
</div>
<div class="form-group col-md-4">
    <label for="email">E-mail</label>
    <input type="text" class="form-control" name="email" value="{{ $conta->email ?? old('email') }}" placeholder="[ Ex: nome.sobrenome@usp.br ]">
</div>
<div class="form-group col-md-1">
    <label for="numero">Número</label>
    <input type="text" class="form-control" name="numero" value="{{ $conta->numero ?? old('numero') }}" placeholder="[ Ex: 1 ]">
</div>
<div class="form-group col-md-1">
    <label class="checkbox-inline" for="ativo">Ativo<br>
    <input type="checkbox" id="ativo" name="ativo" value="1" 
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
                <input type="submit" class="btn btn-primary" value="Salvar">
                <input type="reset" class="btn btn-warning" value="Desfazer">
            </div>
        </div>
    </div>
</div>
