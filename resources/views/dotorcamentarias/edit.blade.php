@extends('master')

@section('content_header')
    <h1>Editar Dotação Orçamentária</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="POST" action="/dotorcamentarias/{{$dotorcamentaria->id}}">
            @csrf
            @method('patch')
            @include('dotorcamentarias.form')
        </form>
    </div>
</div>

@stop
