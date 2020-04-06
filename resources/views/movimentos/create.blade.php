@extends('master')

@section('content_header')
    <h1>Cadastrar Movimento</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('movimentos') }}">
                {{ csrf_field() }}
                @include('movimentos.form')
            </form>
        </div>
    </div>

@stop
