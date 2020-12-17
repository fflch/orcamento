<div class="form-row">
    <div class="form-group col-md-1">
        <label for="numero">Número</label>
        <input type="text" class="form-control" name="numero" value="{{ $unidade->numero ?? old('numero') }}" placeholder="[ Ex: 08 ]">
    </div>
    <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $unidade->nome ?? old('nome') }}" placeholder="[ Ex: Faculdade de Filosofia, Letras e Ciências Humanas ]">
    </div>
    <div class="form-group col-md-5">
        <label for="departamento">Departamento</label>
        <input type="text" class="form-control" name="departamento" value="{{ $unidade->departamento ?? old('departamento') }}" placeholder="[ Ex: Serviço de Contabilidade ]">
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
