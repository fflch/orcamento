@extends('master')

@section('content_header')
    <h1>Cadastrar Nota</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('notas') }}">
                {{ csrf_field() }}
                @include('notas.form')
            </form>
        </div>
    </div>

@stop
