@extends('master')

@section('content_header')
  <h1>Ficha Orçamentária: {{ $ficorcamentaria->dotacao_id }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('ficorcamentarias.edit',$ficorcamentaria->id) }}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Movimento</b>: {{ $ficorcamentaria->movimento->ano ?? ''}}</li>
        <li class="list-group-item"><b>Dotacao</b>: {{ $ficorcamentaria->dotacao->dotacao ?? '' }}</li>
        <li class="list-group-item"><b>Empenho</b>: {{ $ficorcamentaria->empenho }}</li>
        <li class="list-group-item"><b>Descrição</b>: {{ $ficorcamentaria->descricao }}</li>

        <li class="list-group-item"><b>Débito</b>: {{ $ficorcamentaria->debito }}</li>
        <li class="list-group-item"><b>Crédito</b>: {{ $ficorcamentaria->credito }}</li>
        <li class="list-group-item"><b>Observação</b>: {{ $ficorcamentaria->observacao }}</li>

        
        <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $ficorcamentaria->user->name ?? '' }}</li>

    </ul>
</div>

@stop