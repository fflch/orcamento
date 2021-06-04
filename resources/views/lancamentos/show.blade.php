@extends('master')

@section('title')
    Lançamento: {{ $lancamento->conta->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Lançamento: {{ $lancamento->conta->nome }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $lancamento->id }}</li>
        <li class="list-group-item"><b>Movimento:</b> {{ $lancamento->movimento->ano ?? ''}}</li>
        <li class="list-group-item"><b>Conta:</b> {{ $lancamento->conta->nome ?? '' }}</li>
        <li class="list-group-item"><b>Grupo:</b> {{ $lancamento->grupo }}</li>
        <li class="list-group-item"><b>Receita:</b>@if ($lancamento->receita == 1) [ x ] @else [ &nbsp; ] @endif</li>
        <li class="list-group-item"><b>Empenho:</b> {{ $lancamento->empenho }}</li>
        <li class="list-group-item"><b>Descrição:</b> {{ $lancamento->descricao }}</li>
        <li class="list-group-item"><b>Débito:</b> @if($lancamento->debito != 0.00) {{ $lancamento->debito }} @endif</li>
        <li class="list-group-item"><b>Crédito:</b> @if($lancamento->credito != 0.00) {{ $lancamento->credito }} @endif</li>
        <li class="list-group-item"><b>Saldo:</b> {{ $lancamento->saldo }}</li>
        <li class="list-group-item"><b>Observação:</b> {{ $lancamento->observacao }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $lancamento->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $lancamento->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $lancamento->updated_at ?? '' }}</li>
    </ul>
</div>
@can('admin')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('lancamentos.edit',$lancamento->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('lancamentos.destroy', $lancamento) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Lançamento?');">Deletar</button>
        </form>
    </div>
</div>
@endcan
@stop
