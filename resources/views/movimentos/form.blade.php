<div class="form-group">
    <label for="ano">Ano</label>
    <input type="text" class="form-control" name="ano" value="{{ $movimento->ano ?? old('ano') }}" placeholder="Ex: 2099">
</div>

<div class="form-group">
    <label class="checkbox-inline"><input type="checkbox" name="concluido" value="1"
        @if (isset($movimento->id) and ($movimento->concluido === 1))
                checked
        @endif >
        <label for="concluido"> Concluído</label></label>
</div>

<div class="form-group">
    <label class="checkbox-inline"><input type="checkbox" name="ativo" value="1"
        @if (isset($movimento->id) and ($movimento->ativo === 1))
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