@extends('master')

@section('content_header')
  <h1>Conta x Usuário: {{ $contausuario->id }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('contausuarios.edit',$contausuario->id) }}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Conta</b>: {{ $contausuario->conta->nome ?? '' }}</li>
        <li class="list-group-item"><b>Usuário</b>: {{ $contausuario->usuario->name ?? '' }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $contausuario->user->name ?? '' }}</li>
    </ul>
</div>

@stop