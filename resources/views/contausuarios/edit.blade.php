@extends('master')

@section('content_header')
    <h1>Editar Conta x Usuário</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="/contausuarios/{{$contausuario->id}}">
            @csrf
            @method('patch')
            @include('contausuarios.form')
        </form>
    </div>
</div>

@stop
