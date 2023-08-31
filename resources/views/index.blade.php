@extends('master')
@section('title', 'SisConOrc - Sistema de Controle Orçamentário')
@section('content')
    @parent
    @auth
    <div class="card p-3">
        @include('partials.mostra_ano')
        <p>
            <strong>Bem-vindo.</strong><br>
            Você fez login com sucesso no <strong>Sistema de Controle Orçamentário (SisConOrc)</strong>.
            Utilize o menu acima para usar os recursos do sistema. Caso o menu não esteja aparecendo, significa que você não tem um <strong>perfil</strong>.
            Seu perfil atual é: <strong>{{ $perfil_logado }}</strong>.
            As opções do menu podem variar de acordo com o seu perfil.
            O movimento atualmente ativo é o <strong> {{ $movimento_ativo }} </strong>.
            A seção atual tem o movimento <strong>{{ session('ano') }}</strong> definido como padrão.
            Para sair, clique em <strong>Sair</strong> logo acima à direita, ao lado do seu nome e e-mail.
        </p>
    </div>
    @else
    <div class="card p-3">
        <p>
            <strong>Bem-vindo.</strong><br>
            Você ainda não fez login no <strong>Sistema de Controle Orçamentário (SisConOrc)</strong>. Faça-o utilizando <strong>número USP</strong> e <strong>senha única</strong>.
            Clique <a href="/login">aqui</a> ou em <strong>Entrar</strong> logo acima à direita.
        </p>
    </div>
    @endauth
@stop
