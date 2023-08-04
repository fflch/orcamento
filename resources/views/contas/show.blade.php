@extends('master')
@section('title')
    Contas: {{ $conta->nome }}
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Contas: {{ $conta->nome }}</strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">        
        <div class="form-group col-md-6"><b>Tipo de Conta:</b> {{ $conta->tipoconta->descricao ?? '' }}</div>
    </div>
    <div class="form-row">        
        <div class="form-group col-md-6"><b>Nome:</b> {{ $conta->nome }}</div>
        <div class="form-group col-md-3"><b>E-mail:</b> {{ $conta->email }}</div>
        <div class="form-group col-md-2"><b>Número:</b> {{ $conta->numero }}</div>
        <div class="form-group col-md-1"><b>Ativo:</b>@if ($conta->ativo == 1) [ x ] @else [ &nbsp; ] @endif </div>
    </div>        
    <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $conta->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($conta->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($conta->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
<br>
<div class="card p-3">
    <div class="form-row">
        <div class="form-group col-md-8">
            <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
            <a href="{{ route('contas.edit',$conta->id) }}" class="btn btn-warning">Editar</a>
        </div>
        <div class="form-group col-md-4" align="right">
            <form method="post" role="form" action="{{ route('contas.destroy', $conta) }}" >
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta?');">Deletar</button>
            </form>
        </div>
    </div>
</div>
@endcan
@stop
