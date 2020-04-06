@extends('master')

@section('content_header')
    <h1>Editar Movimento</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="{{ action('MovimentoController@update', $movimento->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('movimentos.form')
        </form>
    </div>
</div>

@stop
