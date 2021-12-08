<div class="form-group col-md-6 p-3">
  <div class="card p-3">
    <h3><strong>Ficha Orçamentária</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/ficha_orcamentaria">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input list="dotacoes" name="dotacao_id" id="dotacao_id" class="form-control" value="{{ $ficorcamentaria->dotacao ?? old('dotacao') }}" placeholder="[ Informe a Dotação ]">
        <datalist id="dotacoes">
          @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
            <option value="{{ $lista_dotorcamentaria->id }}">{{ $lista_dotorcamentaria->dotacao }}
          @endforeach
        </datalist>
        <input type="text" class="form-control datepicker data" name="data_inicial" value="01/01/{{ $movimento_ativo->ano }}" placeholder="[ Ex: 01/01/2020 ]">&nbsp;
        <input type="text" class="form-control datepicker data" name="data_final" value="31/12/{{ $movimento_ativo->ano }}" placeholder="[ Ex: 01/01/2020 ]">
        <input list="descricoes" name="descricao" id="descricao" class="form-control" value="{{ $lancamento->descricao ?? old('descricao') }}" placeholder="[ Informe a Descrição ]">
        <datalist id="descricoes">
          @foreach($lista_descricoes as $lista_descricao)
            <option value="{{ $lista_descricao->texto }}">{{ $lista_descricao->texto }}
          @endforeach
        </datalist>
        <input list="observacoes" name="observacao" id="observacao" class="form-control" value="{{ $lancamento->observacao ?? old('observacao') }}" placeholder="[ Informe a Observação ]">
        <datalist id="observacoes">
          @foreach($lista_observacoes as $lista_observacao)
            <option value="{{ $lista_observacao->texto }}">{{ $lista_observacao->texto }}
          @endforeach
        </datalist>        
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>
