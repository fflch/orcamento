@extends('master')

@section('content_header')
    <h1>Cadastrar Ficha Orçamentária</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('ficorcamentarias') }}">
                {{ csrf_field() }}
                @include('ficorcamentarias.form')
            </form>
        </div>
    </div>

@stop
