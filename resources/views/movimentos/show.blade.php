@extends('master')

@section('title')
    Movimento: {{ $movimento->ano }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Movimento: {{ $movimento->ano }}</strong></h2>
</div>
<br>

<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-8"><b>Ano:</b> {{ $movimento->ano }}</div>
        <div class="form-group col-md-2"><b>Concluído:</b>@if ($movimento->concluido == 1) [ x ] @else [ &nbsp; ] @endif </div>
        <div class="form-group col-md-2"><b> Ativo:</b>@if ($movimento->ativo == 1) [ x ] @else [ &nbsp; ] @endif</div>
</div>        
<div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $movimento->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($movimento->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($movimento->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
    </div>
@can('Administrador')
<br>
<div class="card p-3">
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
        <a href="{{ route('movimentos.edit',$movimento->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-11" align="right">
        <form method="post" role="form" action="{{ route('movimentos.destroy', $movimento) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Movimento?');">Deletar</button>
        </form>
    </div>
</div>
</div>
@endcan
@stop
