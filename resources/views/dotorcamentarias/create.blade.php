@extends('master')

@section('content_header')
    <h1>Cadastrar Dotação Orçamentária</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('dotorcamentarias') }}">
                {{ csrf_field() }}
                @include('dotorcamentarias.form')
            </form>
        </div>
    </div>

@stop
