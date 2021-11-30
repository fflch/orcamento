<div class="form-row">
    <div class="form-group col-md-8">
        <label for="conta">Conta</label>
        <select class="contas_select form-control" name="conta_id" tabindex="1">
            <option value=" ">&nbsp;</option>
            @foreach($lista_contas_ativas as $lista_conta_ativa)
                <option value="{{ $lista_conta_ativa->id }}" @if(old('conta_id') == $lista_conta_ativa->id) {{'selected'}}
                    @else {{($lancamento->conta_id === $lista_conta_ativa->id ) ? 'selected' : ''}} @endif>
                    {{ $lista_conta_ativa->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-1">
        <label for="grupo">Grupo</label>
        <input type="text" class="form-control" name="grupo" value="{{ $lancamento->grupo ?? old('grupo') }}" placeholder="[ Ex: 080 ]" tabindex="2">
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
        <input type="text" class="form-control datepicker data" name="data" value="{{ $lancamento->data ?? old('data') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: {{ Carbon\Carbon::now()->format('d/m/Y') }} ]" tabindex="3">
    </div>
    <div class="form-group col-md-1">
        <label for="empenho">Empenho</label>
        <input type="text" class="form-control" name="empenho" value="{{ $lancamento->empenho ?? old('empenho') }}" placeholder="[ Ex: 1234567 ]" tabindex="4">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <input list="descricoes" name="descricao" id="descricao" class="form-control" value="{{ $lancamento->descricao ?? old('descricao') }}" tabindex="5">
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
        <input type="text" class="form-control" name="debito" value="{{ $lancamento->debito ?? old('debito') }}" placeholder="[ Ex: 100,00 ]" tabindex="6">
    </div>
    <div class="form-group col-md-6">
        <label for="credito">Crédito</label>
        <input type="text" class="form-control" name="credito" value="{{ $lancamento->credito ?? old('credito') }}" placeholder="[ Ex: 100,00 ]" tabindex="7">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="observacao">Observação</label>
        <input list="observacoes" name="observacao" id="observacao" class="form-control" value="{{ $lancamento->observacao ?? old('observacao') }}" tabindex="8">
        <datalist id="observacoes">
            @foreach($lista_observacoes as $lista_observacao)
            <option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
            @endforeach
        </datalist>
    </div>
</div>

<div class="card p-3">    
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="percentual1">Percentual #1</label>
            <input type="number" class="form-control" name="percentual1" value="{{ $lancamento->percentual1 ?? old('percentual1') ?? 100 }}" maxlength="3" placeholder="[ Ex: 100% ]" tabindex="9">
        </div>
        <div class="form-group col-md-3">
            <label for="percentual2">Percentual #2 ({{ $nome_conta_numero2[0]->nome }})</label>
            <input type="number" class="form-control" name="percentual2" value="{{ $lancamento->percentual2 ?? old('percentual2') ?? 0 }}" maxlength="3" placeholder="[ Ex: 100% ]" tabindex="10">
        </div>
        <div class="form-group col-md-3">
            <label for="percentual3">Percentual #3 ({{ $nome_conta_numero3[0]->nome }})</label>
            <input type="number" class="form-control" name="percentual3" value="{{ $lancamento->percentual3 ?? old('percentual3') ?? 0 }}" maxlength="3" placeholder="[ Ex: 100% ]" tabindex="11">
        </div>
        <div class="form-group col-md-3">
            <label for="percentual4">Percentual #4 ({{ $nome_conta_numero4[0]->nome }})</label>
            <input type="number" class="form-control" name="percentual4" value="{{ $lancamento->percentual4 ?? old('percentual4') ?? 0 }} " maxlength="3" placeholder="[ Ex: 100% ]" tabindex="12">
        </div>

    </div>
</div>

<br>
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
