<div class="form-group">
    <label for="descricao">Descrição</label>
    <input type="text" class="form-control" name="descricao" value="{{ $tipoconta->descricao ?? old('descricao') }}" placeholder="Ex: Orçamento">
</div>

<div class="form-group">
    <label class="checkbox-inline"><input type="checkbox" name="cpfo" value="1"
        @if (isset($tipoconta->id) and ($tipoconta->cpfo === 1))
                checked
        @endif >
        <label for="cpfo"> Faz Contra-Partida com a Ficha Orçamentária</label>
    </label>
</div>

<div class="form-group">
    <label class="checkbox-inline"><input type="checkbox" name="relatoriobalancete" value="1"
        @if (isset($tipoconta->id) and ($tipoconta->relatoriobalancete === 1))
                checked
        @endif >
        <label for="relatoriobalancete"> Deve constar no relatório Balancete</label>
    </label>
</div>

<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</div>