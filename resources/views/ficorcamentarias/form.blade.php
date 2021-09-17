<div class="form-row">
    <div class="form-group col-md-4">
        <label for="dotacao">Dotação</label>
        <input list="dotacoes" name="dotacao_id" id="dotacao_id" class="form-control" value="{{ $ficorcamentaria->dotacao ?? old('dotacao') }}">
        <datalist id="dotacoes">
            <!--option value="{{ $ficorcamentaria->descricao ?? old('descricao') }}"-->
            <!--option value=" ">----------</option-->
            @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
                <option value="{{ $lista_dotorcamentaria->id }}">{{ $lista_dotorcamentaria->dotacao }}
            @endforeach
        </datalist>
    </div>

<!--div class="form-row">
<div class="form-group col-md-4">

<label for="dotacao">Dotação</label>
<select class="form-control" list="dotacao_id" name="dotacao_id">
  <option value="{{ $ficorcamentaria->dotacao_id ?? old('dotacao_id') }}">{{ $ficorcamentaria->dotacao->dotacao ?? old('dotorcamentaria_dotacao') }}</option>
  <option value=" ">----------</option>
    @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
        <option value="{{ $lista_dotorcamentaria->id }}">{{ $lista_dotorcamentaria->dotacao }}
    @endforeach
</select>

</div-->

    <div class="form-group col-md-4">
        <label for="data">Data</label>
        <input type="text" class="form-control datepicker data" name="data" value="{{ $ficorcamentaria->data ?? old('data') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">
    </div>
    <div class="form-group col-md-4">
        <label for="empenho">Empenho</label>
        <input type="text" class="form-control" name="empenho" value="{{ $ficorcamentaria->empenho ?? old('empenho') }}" placeholder="[ Ex: 1234567 ]">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="descricao">Descrição</label>
        <!--input class="form-control" list="descricao" name="descricao"-->
        <input list="descricoes" name="descricao" id="descricao" class="form-control" value="{{ $ficorcamentaria->descricao ?? old('descricao') }}">
        <datalist id="descricoes">
            <!--option value="{{ $ficorcamentaria->descricao ?? old('descricao') }}"-->
            <!--option value=" ">----------</option-->
            @foreach($lista_descricoes as $lista_descricao)
                <option value="{{ $lista_descricao->texto }}">{{ $lista_descricao->texto }}
            @endforeach
        </datalist>
    </div>
</div>

<div class="form-row">
<div class="form-group col-md-6">
    <label for="debito">Débito</label>
    <input type="text" class="form-control" name="debito" value="{{ $ficorcamentaria->debito ?? old('debito') }}" placeholder="[ Ex: 100,00 ]">
</div>
<div class="form-group col-md-6">
    <label for="credito">Crédito</label>
    <input type="text" class="form-control" name="credito" value="{{ $ficorcamentaria->credito ?? old('credito') }}" placeholder="[ Ex: 100,00 ]">
</div>
</div>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="observacao">Observação</label>
        <!--input class="form-control" list="observacao" name="observacao"-->
        <input list="observacoes" name="observacao" id="observacao" class="form-control" value="{{ $ficorcamentaria->observacao ?? old('observacao') }}">
        <datalist id="observacoes">
            <!--option selected value="{{ $ficorcamentaria->observacao ?? old('observacao') }}"-->
            <!--option value=" ">----------</option-->
            @foreach($lista_observacoes as $lista_observacao)
            <option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
            @endforeach
        </datalist>
    </div>
</div>

<!--div class="form-row">
    <div class="form-group col-md-12">
        <label for="browser">Choose your browser from the list:</label>
        <input list="browsers" name="browser" id="browser">
        <datalist id="browsers">
            <option value="Edge">
            <option value="Firefox">
            <option value="Chrome">
            <option value="Opera">
            <option value="Safari">
        </datalist>
    </div>
</div-->

<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar">
                <input type="reset" class="btn btn-warning" value="Desfazer">
                <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
            </div>
        </div>
    </div>
</div>
