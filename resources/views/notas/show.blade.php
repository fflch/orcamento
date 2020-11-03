@extends('master')

@section('content_header')
  <h1>Nota: {{ $nota->texto }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('notas.edit',$nota->id) }}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Tipo de Conta</b>: {{ $nota->tipoconta->descricao ?? '' }}</li>
        <li class="list-group-item"><b>Texto</b>: {{ $nota->texto }}</li>
        <li class="list-group-item"><b>Tipo</b>: {{ $nota->tipo }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $nota->user->name ?? '' }}</li>
    </ul>
</div>

@stop