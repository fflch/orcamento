@extends('master')

@section('title')
  Adicionar Contra-Partida da Ficha Orçamentária
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Contra-Partida da Ficha Orçamentária</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ route('ficorcamentarias.store') }}">
    <input type="hidden" id="dotacao_id_fo" name="dotacao_id_fo" value="{{ $request_FO->dotacao_id }}">
    <input type="hidden" id="data_fo" name="data_fo" value="{{ $request_FO->data }}">
    <input type="hidden" id="empenho_fo" name="empenho_fo" value="{{ $request_FO->empenho }}">
    <input type="hidden" id="descricao_fo" name="descricao_fo" value="{{ $request_FO->descricao }}">
    @if($request_FO->debito != 0)
    <input type="hidden" id="debito_fo" name="debito_fo" value="{{ $request_FO->debito }}">
    @else
    <input type="hidden" id="credito_fo" name="credito_fo" value="{{ $request_FO->credito }}">
    @endif
    <input type="hidden" id="observacao_fo" name="observacao_fo" value="{{ $request_FO->observacao }}">
      @csrf
      @include('ficorcamentarias.formcp')
    </form>
  </div>
</div>
@stop
