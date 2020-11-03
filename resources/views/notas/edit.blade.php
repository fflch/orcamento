@extends('master')

@section('content_header')
    <h1>Editar Nota</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="/notas/{{$nota->id}}">
            @csrf
            @method('patch')
            @include('notas.form')
        </form>
    </div>
</div>

@stop
