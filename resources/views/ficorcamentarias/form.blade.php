<div class="form-group">
    <label for="dotacao">Dotação</label>
<input class="form-control" list="dotacao_id" name="dotacao_id">
<datalist id="dotacao_id">
<option value="{{ $ficorcamentaria->dotacao_id ?? old('dotacao_id') }}">{{ $ficorcamentaria->dotacao->dotacao ?? old('dotorcamentaria_dotacao') }}</option>
        <option value=" ">----------</option>
@foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
<option value="{{ $lista_dotorcamentaria->id }}">{{ $lista_dotorcamentaria->dotacao }}
  @endforeach
</datalist>
</div>


<div class="form-group">
    <label for="data">Data</label>
    <input type="text" class="form-control" name="data" value="{{ $ficorcamentaria->data ?? old('data') }}" placeholder="Ex: 01/01/2020">
</div>
<div class="form-group">
    <label for="empenho">Empenho</label>
    <input type="text" class="form-control" name="empenho" value="{{ $ficorcamentaria->empenho ?? old('empenho') }}" placeholder="Ex: 1234567">
</div>

<div class="form-group">
    <label for="descricao">Descrição</label>
<input class="form-control" list="descricao" name="descricao">
<datalist id="descricao">{{ $lancamento->descricao ?? old('descricao') }}
<option value="{{ $ficorcamentaria->descricao ?? old('descricao') }}">
        <option value=" ">----------</option>
@foreach($lista_descricoes as $lista_descricao)
<option value="{{ $lista_descricao->texto }}">{{ $lista_descricao->texto }}
  @endforeach
</datalist>
</div>

<div class="form-group">
    <label for="debito">Débito</label>
    <input type="text" class="form-control" name="debito" value="{{ $ficorcamentaria->debito ?? old('debito') }}" placeholder="Ex: 100,00">
</div>
<div class="form-group">
    <label for="credito">Crédito</label>
    <input type="text" class="form-control" name="credito" value="{{ $ficorcamentaria->credito ?? old('credito') }}" placeholder="Ex: 100,00">
</div>

<div class="form-group">
    <label for="observacao">Observação</label>
<input class="form-control" list="observacao" name="observacao">
<datalist id="observacao">
<option value="{{ $ficorcamentaria->observacao ?? old('observacao') }}">
        <option value=" ">----------</option>
@foreach($lista_observacoes as $lista_observacao)
<option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
  @endforeach
</datalist>
</div>

<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</div>