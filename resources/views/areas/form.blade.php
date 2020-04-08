<div class="form-group">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" value="{{ $area->nome ?? old('nome') }}" placeholder="Ex: Administrativa">
</div>

<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</div>