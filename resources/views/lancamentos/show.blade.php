@extends('master')

@section('content_header')
  <h1>Lançamento: {{ $lancamento->conta_id }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('lancamentos.edit',$lancamento->id) }}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Movimento</b>: {{ $lancamento->movimento->ano ?? ''}}</li>
        <li class="list-group-item"><b>Conta</b>: {{ $lancamento->conta->nome ?? '' }}</li>
        <li class="list-group-item"><b>Grupo</b>: {{ $lancamento->grupo }}</li>
        <li class="list-group-item"> @if ($lancamento->receita == 1) X @endif <b> Receita</b></li>
        <li class="list-group-item"><b>Empenho</b>: {{ $lancamento->empenho }}</li>
        <li class="list-group-item"><b>Descrição</b>: {{ $lancamento->descricao }}</li>

        <li class="list-group-item"><b>Débito</b>: {{ $lancamento->debito }}</li>
        <li class="list-group-item"><b>Crédito</b>: {{ $lancamento->credito }}</li>
        <li class="list-group-item"><b>Observação</b>: {{ $lancamento->observacao }}</li>

        
        <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $lancamento->user->name ?? '' }}</li>

    </ul>
</div>

@stop