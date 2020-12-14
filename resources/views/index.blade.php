@extends('master')

@section('title', 'SisConOrc')

@section('content_header')
    <h1>Sistema de Controle Orçamentário</h1>
@stop

@section('content')
    @parent
        @auth            
            Você fez login com sucesso. Utilize o menu acima para usar os recursos do sistema.
        @else
            Você ainda não fez login. Faça-o utilizando número USP e senha única. Clique <a href="/login">aqui</a>.
        @endauth
@stop