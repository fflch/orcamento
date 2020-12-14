@extends('master')

@section('content_header')
  <h1>Unidade: {{ $unidade->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('unidades.edit',$unidade->id) }}" class="btn btn-success">Editar</a>

</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Número</b>: {{ $unidade->numero }}</li>
        <li class="list-group-item"><b>Nome</b>: {{ $unidade->nome }}</li>
        <li class="list-group-item"><b>Departamento</b>: {{ $unidade->departamento }}</li>

        <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $unidade->user->name ?? '' }}</li>
    </ul>
</div>

@stop