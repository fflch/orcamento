@extends('master')

@section('content_header')
    <h1>Editar Conta</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="/contas/{{$conta->id}}">
            @csrf
            @method('patch')
            @include('contas.form')
        </form>
    </div>
</div>

@stop
