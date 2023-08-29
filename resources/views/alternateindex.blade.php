@extends('master')
@section('title', 'SisConOrc - Sistema de Controle Orçamentário')
@section('content')
    @parent
    <div class="card p-3">
        <p>
            <strong>Não foi possível localizar um ano ativo, portanto, o login no sistema está indisponível.</strong><br>
            Entre em contato com o Serviço de Contabilidade.
        </p>
    </div>
@stop
