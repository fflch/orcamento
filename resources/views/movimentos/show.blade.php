@extends('master')

@section('content_header')
  <h1>Movimento: {{ $movimento->ano }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('movimentos.edit',$movimento->id) }}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Ano</b>: {{ $movimento->ano }}</li>
        <li class="list-group-item"> 
@if ($movimento->concluido == 1)
                      X
                    @endif 
         <b> Concluído</b></li>
        <li class="list-group-item"> 
@if ($movimento->ativo == 1)
                      X
                    @endif 
        <b> Ativo</b></li>
    </ul>
</div>

@stop