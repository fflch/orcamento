@extends('master')
@section('title')
    Tipos de Contas - {{ $tipoconta->descricao }}
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Tipos de Contas - {{ $tipoconta->descricao }}</strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-6"><b>Descrição:</b> {{ $tipoconta->descricao }}</div>
        <div class="form-group col-md-3"><b>Faz Contra-Partida com a Ficha Orçamentária:</b>@if ($tipoconta->cpfo == 1) [ x ] @else [ &nbsp; ] @endif</div>
        <div class="form-group col-md-3"><b>Deve constar no relatório Balancete:</b>@if ($tipoconta->relatoriobalancete == 1) [ x ] @else [ &nbsp; ] @endif</div>
    </div>        
    <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $tipoconta->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($tipoconta->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($tipoconta->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
    <br>
    <div class="card p-3">
        <div class="form-row">
            <div class="form-group col-md-8">
                <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
                <a href="{{ route('tipocontas.edit',$tipoconta->id) }}" class="btn btn-warning">Editar</a>
            </div>
            <div class="form-group col-md-4" align="right">
                <form method="post" role="form" action="{{ route('tipocontas.destroy', $tipoconta) }}" >
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Tipo de Conta?');">Excluir</button>
                </form>
            </div>
        </div>
    </div>
@endcan
@stop
