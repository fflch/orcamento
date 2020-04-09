@extends('master')

@section('content_header')
    <h1>Editar Dotação Orçamentária</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="{{ action('DotOrcamentariaController@update', $dotorcamentaria->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('dotorcamentarias.form')
        </form>
    </div>
</div>

@stop
