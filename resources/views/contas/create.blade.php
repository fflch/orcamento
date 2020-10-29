@extends('master')

@section('content_header')
    <h1>Cadastrar Conta</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('contas') }}">
                {{ csrf_field() }}
                @include('contas.form')
            </form>
        </div>
    </div>

@stop
