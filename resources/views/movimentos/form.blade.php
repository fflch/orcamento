<div class="form-row">
<div class="form-group col-md-10">
    <label for="ano">Ano</label>
    <input type="text" class="form-control" name="ano" value="{{ $movimento->ano ?? old('ano') }}" placeholder="Ex: 2099">
</div>

<div class="form-group col-md-1">
    <label class="checkbox-inline" for="concluido">Concluído<br>
    <input type="checkbox" id="concluido" name="concluido" value="1"
        @if (isset($movimento->id) and ($movimento->concluido === 1))
             checked
        @else
            value="0"
        @endif >
        </label>
</div>

<div class="form-group col-md-1">
    <label class="checkbox-inline" for="ativo">Ativo<br>
    <input type="checkbox" id="ativo" name="ativo" value="1" 
        @if (isset($movimento->id) and ($movimento->ativo === 1))
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
