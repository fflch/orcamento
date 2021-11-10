<div class="form-row">
    <div class="form-group col-md-12">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $area->nome ?? old('nome') }}" placeholder="[ Ex: Administrativa ]" tabindex="1">
    </div>
</div>

<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar" tabindex="2">
                <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="3">
            </div>
        </div>
    </div>
</div>
