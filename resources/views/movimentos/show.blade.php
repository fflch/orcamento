@extends('master')

@section('content_header')
  <h1>Movimento: {{ $movimento->ano }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{action('MovimentoController@edit', $movimento->id)}}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Ano</b>: {{ $movimento->ano }}</li>
        <li class="list-group-item"><b>Concluído</b>: 
@if ($movimento->concluido == 1)
                      X
                    @endif 
         </li>
        <li class="list-group-item"><b>Ativo</b>: 
@if ($movimento->ativo == 1)
                      X
                    @endif 
        </li>
    </ul>
</div>

@stop