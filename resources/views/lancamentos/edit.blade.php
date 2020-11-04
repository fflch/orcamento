@extends('master')

@section('content_header')
    <h1>Editar Lançamento</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="/lancamentos/{{$lancamento->id}}">
            @csrf
            @method('patch')
            @include('lancamentos.form')
        </form>
    </div>
</div>

@stop
