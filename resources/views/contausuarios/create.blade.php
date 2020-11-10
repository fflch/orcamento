@extends('master')

@section('content_header')
    <h1>Cadastrar Conta x Usuário</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('contausuarios') }}">
                {{ csrf_field() }}
                @include('contausuarios.form')
            </form>
        </div>
    </div>

@stop
