@extends('master')

@section('title')
    Tipo de Conta: {{ $tipoconta->descricao }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Tipo de Conta: {{ $tipoconta->descricao }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $tipoconta->id }}</li>
        <li class="list-group-item"><b>Descrição:</b> {{ $tipoconta->descricao }}</li>
        <li class="list-group-item"><b>Faz Contra-Partida com a Ficha Orçamentária:</b>@if ($tipoconta->cpfo == 1) [ x ] @else [ &nbsp; ] @endif</li>
        <li class="list-group-item"><b>Deve constar no relatório Balancete:</b>@if ($tipoconta->relatoriobalancete == 1) [ x ] @else [ &nbsp; ] @endif</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $tipoconta->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $tipoconta->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $tipoconta->updated_at ?? '' }}</li>
    </ul>
</div>
@can('admin')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('tipocontas.edit',$tipoconta->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('tipocontas.destroy', $tipoconta) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Tipo de Conta?');">Deletar</button>
        </form>
    </div>
</div>
@endcan
@stop
