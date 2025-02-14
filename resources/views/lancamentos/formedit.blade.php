<div class="form-row">
    <div class="form-group col-md-1">
        <label for="grupo">Grupo</label>
        <input type="text" class="form-control" name="grupo" value="{{ $lancamento->grupo ?? old('grupo') ?? 80 }}" placeholder="[ Ex: 080 ]" tabindex="2">
    </div>
    <div class="form-group col-md-1">
        <label for="receita" class="checkbox-inline">Receita</label><br>
        <input type="checkbox" name="receita" id="receita" value="1" tabindex="3"
            @if (isset($lancamento->id) and ($lancamento->receita === 1))
            checked
            @endif >
    </div>
    <div class="form-group col-md-1">
        <label fo col-md-2r="data">Data</label>
        <input type="text" class="form-control datepicker data" name="data" value="{{ old('data', $lancamento->data) }}" placeholder="[ Ex: {{ Carbon\Carbon::now()->format('d/m/Y') }} ]" tabindex="3">
    </div>
    <div class="form-group col-md-1">
        <label for="empenho">Empenho</label>
        <input type="text" class="form-control" name="empenho" value="{{ old('empenho', $lancamento->empenho) }}" placeholder="[ Ex: 1234567 ]" tabindex="4">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <input list="descricoes" name="descricao" id="descricao" class="form-control" value="{{ old('descricao', $lancamento->descricao) }}" tabindex="5">
        <datalist id="descricoes">
            @foreach($lista_descricoes as $lista_descricao)
                <option value="{{ $lista_descricao->texto }}">{{ $lista_descricao->texto }}
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="debito">Débito</label>
        <input type="text" class="form-control" name="debito" value="{{ old('debito', $lancamento->debito) }}" placeholder="[ Ex: 100,00 ]" tabindex="6">
    </div>
    <div class="form-group col-md-6">
        <label for="credito">Crédito</label>
        <input type="text" class="form-control" name="credito" value="{{ old('credito', $lancamento->credito) }}" placeholder="[ Ex: 100,00 ]" tabindex="7">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="observacao">Observação</label>
        <input list="observacoes" name="observacao" id="observacao" class="form-control" value="{{ old('observacao', $lancamento->observacao) }}" tabindex="8">
        <datalist id="observacoes">
            @foreach($lista_observacoes as $lista_observacao)
                <option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
            @endforeach
        </datalist>
    </div>
</div>
<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar" tabindex="13">
                <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="14">
                <a href="{{ url()->previous() }}" class="btn btn-info" tabindex="15">Voltar</a>
            </div>
        </div>
    </div>
</div>
