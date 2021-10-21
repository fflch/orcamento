@extends('master')

@section('title')
    Relatórios
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
    <h2><strong>Relatórios</strong></h2>
</div>
<br> 

<div class="form-row">

<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Balancete</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/balancete">
    @csrf
    <div class="row">
    <div class="col-sm input-group">
    <input type="text" class="form-control datepicker data" name="data" value="{{ Carbon\Carbon::now()->format('d/m/Y') }}">
    <span class="input-group-btn">
      <button type="submit" class="btn btn-success"><strong>OK</strong></button>
    </span>
    </div>
    </div>
  </form>
</div>

<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Acompanhamento</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/acompanhamento">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
        <label for="receita" class="checkbox-inline">Receita</label><br>
        <input type="checkbox" name="receita" id="receita" value="1" @if (isset($lancamento->id) and ($lancamento->receita === 1)) checked @endif >
        <input type="text" class="form-control" name="referencia" value=" - Outubro/2021" placeholder="[ Referência ]">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>

<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Saldo de Contas</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/saldo_contas">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input list="contas" name="conta_id" id="conta_id" class="form-control" value="{{ old('conta_id') }}" placeholder="[ Informe a Conta ]">
        <datalist id="contas">
          @foreach($lista_contas as $lista_conta)
            <option value="{{ $lista_conta->id }}">{{ $lista_conta->nome }}
          @endforeach
        </datalist>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>

<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Saldo de Dotações</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/saldo_dotacoes">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>

</div>

<div class="form-row">

<div class="form-group col-md-6 p-3">
  <div class="card p-3">
    <h3><strong>Lançamentos</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/lancamentos">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
      <input list="contas" name="conta_id" id="conta_id" class="form-control" value="{{ old('conta_id') }}" placeholder="[ Informe a Conta ]">
      <datalist id="contas">
        @foreach($lista_contas as $lista_conta)
          <option value="{{ $lista_conta->id }}">{{ $lista_conta->nome }}
        @endforeach
      </datalist>
      <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
      <label for="receita" class="checkbox-inline">Receita</label><br>
      <input type="checkbox" name="receita" id="receita" value="1" @if (isset($lancamento->id) and ($lancamento->receita === 1)) checked @endif >
      <input type="text" class="form-control datepicker data" name="data_inicial" value="{{ Request()->data_inicial ?? old('data_inicial') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">&nbsp;
      <input type="text" class="form-control datepicker data" name="data_final" value="{{ Request()->data_final ?? old('data_final') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">
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
        <input type="text" class="form-control datepicker data" name="data_inicial" value="{{ Request()->data_inicial ?? old('data_inicial') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">&nbsp;
        <input type="text" class="form-control datepicker data" name="data_final" value="{{ Request()->data_final ?? old('data_final') ?? Carbon\Carbon::now()->format('d/m/Y') }}" placeholder="[ Ex: 01/01/2020 ]">
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

</div>

<div class="form-row">

<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Despesas</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/despesas">
    @csrf
    <div class="row">
      <div class=" col-sm input-group">
        <input list="areas" name="area_id" id="area_id" class="form-control" value="{{ $conta->area_id ?? old('area_id') }}" placeholder="[ Informe a Área ]">
        <datalist id="areas">
          @foreach($lista_areas as $lista_area)
          <option value="{{ $lista_area->id }}">{{ $lista_area->nome }}
          @endforeach
        </datalist>
        <select name="Descricao" id="select2" class="form-control">
          <option value="Despesas com Almoxarifado">Despesas com Almoxarifado</option>
          <option value="Despesas com Servi&ccedil;os Postais">Despesas com Servi&ccedil;os Postais</option>
          <option value="Despesas Mi&uacute;das">Despesas Mi&uacute;das</option>
          <option value="Despesas com Material de Consumo">Despesas com Material de Consumo</option>
        </select>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>

<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Despesas Miúdas</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/despesas_miudas">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input type="text" class="form-control datepicker data" name="data_inicial" value="{{ Carbon\Carbon::now()->format('d/m/Y') }}">&nbsp;-&nbsp;
        <input type="text" class="form-control datepicker data" name="data_final" value="{{ Carbon\Carbon::now()->format('d/m/Y') }}">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>

</div>

@stop
