@extends('master')

@section('title')
    Conta x Usuário: {{ $contausuario->usuario->name }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
<h2><strong>Conta x Usuário: {{ $contausuario->usuario->name }}</strong></h2>
</div>
<br>    

<div class="card p-4">
<div class="form-row">
        <div class="form-group col-md-8"><b>Usuário:</b> {{ $contausuario->usuario->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Conta:</b> {{ $contausuario->conta->nome ?? '' }}</div>
</div>
        <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $contausuario->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($contausuario->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($contausuario->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
<br>
<div class="card p-3">
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('contausuarios.edit',$contausuario->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
</div>
    <div class="form-group col-md-11" align="right">
        <form method="post" role="form" action="{{ route('contausuarios.destroy', $contausuario) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta x Usuário?');">Deletar</button>
        </form>
    </div>
</div>
</div>
@endcan
@stop
