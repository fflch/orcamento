@extends('master')

@section('content_header')
    <h1>Editar Unidade</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="/unidades/{{$unidade->id}}">
            @csrf
            @method('patch')
            @include('unidades.form')
        </form>
    </div>
</div>

@stop
