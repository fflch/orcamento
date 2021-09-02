@extends('master')

@section('title', 'SisConOrc - Sistema de Controle Orçamentário')

@section('content')
    @parent
        @auth            
            Você fez login com sucesso. Utilize o menu acima para usar os recursos do sistema. O movimento atualmente ativo é o <strong>{{ $movimento_ativo->ano }}</strong>.
        @else
            Você ainda não fez login. Faça-o utilizando número USP e senha única. Clique <a href="/login">aqui</a> ou em <b>Entrar</b> logo acima à direita.
        @endauth
@stop
