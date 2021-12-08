<div class="form-row">
    <div class="form-group col-md-4">
        <label for="dotacao">Dotação</label>
        <input list="dotacoes" name="dotacao_id" id="dotacao_id" class="form-control" value="{{ $ficorcamentaria->dotacao ?? old('dotacao') }}" tabindex="1">
        <datalist id="dotacoes">
            @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
                <option value="{{ $lista_dotorcamentaria->id }}">{{ $lista_dotorcamentaria->dotacao }}
            @endforeach
        </datalist>
    </div>
    <div class="form-group col-md-4">
        <label for="data">Data</label>
        <input type="text" class="form-control datepicker data" name="data" value="{{ $ficorcamentaria->data ?? old('data') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: {{ Carbon\Carbon::now()->format('d/m/Y') }} ]" tabindex="2">
    </div>
    <div class="form-group col-md-4">
        <label for="empenho">Empenho</label>
        <input type="text" class="form-control" name="empenho" value="{{ $ficorcamentaria->empenho ?? old('empenho') }}" placeholder="[ Ex: 1234567 ]" tabindex="3">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <input list="descricoes" name="descricao" id="descricao" class="form-control" value="{{ $ficorcamentaria->descricao ?? old('descricao') }}" tabindex="4">
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
        <input type="number" class="form-control" name="debito" value="{{ $ficorcamentaria->debito ?? old('debito') }}" placeholder="[ Ex: 100,00 ]" tabindex="5">
    </div>
    <div class="form-group col-md-6">
        <label for="credito">Crédito</label>
        <input type="number" class="form-control" name="credito" value="{{ $ficorcamentaria->credito ?? old('credito') }}" placeholder="[ Ex: 100,00 ]" tabindex="6">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="observacao">Observação</label>
        <input list="observacoes" name="observacao" id="observacao" class="form-control" value="{{ $ficorcamentaria->observacao ?? old('observacao') }}" tabindex="7">
        <datalist id="observacoes">
            @foreach($lista_observacoes as $lista_observacao)
            <option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
            @endforeach
        </datalist>
    </div>
</div>
<div class="card p-3">  
    <div class="card-header">
        <label for="tipos_contas">Contra-Partida - Tipos de Contas</label>
    </div>  
    <div class="form-row">
        @foreach($lista_tipos_contas as $lista_tipo_conta)
            @if ($lista_tipo_conta->cpfo)
                <div class="form-group col-md-3">
                    <p>
                        {{ $lista_tipo_conta->descricao }}
                        <input type="number" class="form-control" name="tipocontaid_quantidades[{{ $lista_tipo_conta->id }}]" value="0" placeholder="[ Ex: 1 ]" maxlength="1" tabindex="8">
                    </p>
                </div>
            @endif
        @endforeach
    </div>
</div>
<br>
<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Continuar" tabindex="9">
                <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="10">
                <a href="{{ url()->previous() }}" class="btn btn-info" tabindex="11">Voltar</a>
            </div>
        </div>
    </div>
</div>
