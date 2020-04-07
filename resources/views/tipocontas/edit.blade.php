@extends('master')

@section('content_header')
    <h1>Editar Tipo de Conta</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="{{ action('TipoContaController@update', $tipoconta->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('tipocontas.form')
        </form>
    </div>
</div>

@stop