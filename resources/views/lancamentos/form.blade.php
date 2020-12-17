<div class="form-row">
    <div class="form-group col-md-12">
        <label for="conta">Conta</label>
    <input class="form-control" list="conta_id" name="conta_id">
    <datalist id="conta_id">
    <option value="{{ $lancamento->conta_id ?? old('conta_id') }}">{{ $lancamento->conta->nome ?? old('conta_nome') }}</option>
            <option value=" ">----------</option>
    @foreach($lista_contas as $lista_conta)
    <option value="{{ $lista_conta->id }}">{{ $lista_conta->nome }}
    @endforeach
    </datalist>
    </div>
</div>

<div class="form-row">
<div class="form-group col-md-3">
    <label for="grupo">Grupo</label>
    <input type="text" class="form-control" name="grupo" value="{{ $lancamento->grupo ?? old('grupo') }}" placeholder="[ Ex: 080 ]">
</div>
<div class="form-group col-md-1">
    <label for="receita" class="checkbox-inline">Receita</label>
    <input type="checkbox" name="receita" value="1" 
        @if (isset($lancamento->id) and ($lancamento->receita === 1))
             checked
        @endif >
        </div>
<div class="form-group col-md-4">
    <label fo col-md-2r="data">Data</label>
    <input type="text" class="form-control" name="data" value="{{ $lancamento->data ?? old('data') }}" placeholder="[ Ex: 01/01/2020 ]">
</div>
<div class="form-group col-md-4">
    <label for="empenho">Empenho</label>
    <input type="text" class="form-control" name="empenho" value="{{ $lancamento->empenho ?? old('empenho') }}" placeholder="[ Ex: 1234567 ]">
</div>
</div>
<div class="form-group">
    <label for="descricao">Descrição</label>
<input class="form-control" list="descricao" name="descricao">
<datalist id="descricao">{{ $lancamento->descricao ?? old('descricao') }}
<option value="{{ $lancamento->descricao ?? old('descricao') }}">
        <option value=" ">----------</option>
@foreach($lista_descricoes as $lista_descricao)
<option value="{{ $lista_descricao->texto }}">{{ $lista_descricao->texto }}
  @endforeach
</datalist>
</div>

<div class="form-row">

<div class="form-group col-md-6">
    <label for="debito">Débito</label>
    <input type="text" class="form-control" name="debito" value="{{ $lancamento->debito ?? old('debito') }}" placeholder="[ Ex: 100,00 ]">

</div>
<div class="form-group col-md-6">
    <label for="credito">Crédito</label>
    <input type="text" class="form-control" name="credito" value="{{ $lancamento->credito ?? old('credito') }}" placeholder="[ Ex: 100,00 ]">

</div>
</div>

<div class="form-group">
    <label for="observacao">Observação</label>
<input class="form-control" list="observacao" name="observacao">
<datalist id="observacao">
<option value="{{ $lancamento->observacao ?? old('observacao') }}">
        <option value=" ">----------</option>
@foreach($lista_observacoes as $lista_observacao)
<option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
  @endforeach
</datalist>
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