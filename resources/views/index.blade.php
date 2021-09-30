@extends('master')

@section('title', 'SisConOrc - Sistema de Controle Orçamentário')

@section('content')
    @parent
        @auth            
            Você fez login com sucesso no <strong>Sistema de Controle Orçamentário</strong>. 
            Utilize o menu acima para usar os recursos do sistema. 
            O movimento atualmente ativo é o <strong>{{ $movimento_ativo->ano }}</strong>.
            Para sair, clique em <strong>Sair</strong> logo acima à direita.
        @else
            Você ainda não fez login. Faça-o utilizando número USP e senha única. 
            Clique <a href="/login">aqui</a> ou em <strong>Entrar</strong> logo acima à direita.
        @endauth
@stop
