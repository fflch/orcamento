@extends('master')

@section('title', 'SisConOrc')

@section('content_header')
    <h1>Sistema de Controle Orçamentário</h1>
@stop

@section('content')
    @parent
        @auth            
            Você agora fez seu login com a senha única USP <a href="/logout"> Faça seu Logout! </a>
        @else
            Você ainda não fez seu login com a senha única USP <a href="/login"> Faça seu Login! </a>
        @endauth
@stop