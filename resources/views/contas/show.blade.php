@extends('master')

@section('content_header')
  <h1>Conta: {{ $conta->ano }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('contas.edit',$conta->id) }}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Tipo de Conta</b>: {{ $conta->tipoconta->descricao ?? '' }}</li>
        <li class="list-group-item"><b>Área</b>: {{ $conta->area->nome ?? '' }}</li>

        <li class="list-group-item"><b>Nome</b>: {{ $conta->nome }}</li>
        <li class="list-group-item"><b>E-mail</b>: {{ $conta->email }}</li>
        <li class="list-group-item"><b>Número</b>: {{ $conta->numero }}</li>

        <li class="list-group-item"> 
          @if ($conta->ativo == 1)
            X
          @endif 
        <b> Ativo</b></li>
        <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $conta->user->name ?? '' }}</li>

    </ul>
</div>

@stop