@extends('master')

@section('content_header')
    <h1>Cadastrar Tipo de Conta</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('tipocontas') }}">
                {{ csrf_field() }}
                @include('tipocontas.form')
            </form>
        </div>
    </div>

@stop