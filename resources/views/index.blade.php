@extends('master')

@section('title', 'SisConOrc')

@section('content_header')
    <h1>Sistema de Controle Orçamentário</h1>
@stop

@section('content')
    @parent
        @auth
            <script>window.location = "/";</script>
        @else
            Você ainda não fez seu login com a senha única USP <a href="/senhaunica/login"> Faça seu Login! </a>
        @endauth
@stop