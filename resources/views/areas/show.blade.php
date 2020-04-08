@extends('master')

@section('content_header')
  <h1>Área: {{ $area->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{action('AreaController@edit', $area->id)}}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Nome</b>: {{ $area->nome }}</li>
    </ul>
</div>

@stop