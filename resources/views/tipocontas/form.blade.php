<div class="form-row">
<div class="form-group col-md-7">
    <label for="descricao">Descrição</label>
    <input type="text" class="form-control" name="descricao" value="{{ $tipoconta->descricao ?? old('descricao') }}" placeholder="[ Ex: Orçamento ]">
</div>

<div class="form-group col-md-3">
    <label class="checkbox-inline" for="cpfo">Faz Contra-Partida com a Ficha Orçamentária<br>
    <input type="checkbox" id="cpfo" name="cpfo" value="1"
        @if (isset($tipoconta->id) and ($tipoconta->cpfo === 1))
                checked
        @endif >
        </label>
</div>

<div class="form-group col-md-2">
    <label class="checkbox-inline" for="relatoriobalancete">Deve constar no relatório Balancete<br>
    <input type="checkbox" id="relatoriobalancete" name="relatoriobalancete" value="1"
        @if (isset($tipoconta->id) and ($tipoconta->relatoriobalancete === 1))
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
