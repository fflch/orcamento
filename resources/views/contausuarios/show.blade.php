@extends('master')

@section('title')
    Conta x Usuário: {{ $contausuario->usuario->name }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Conta x Usuário: {{ $contausuario->usuario->name }}</strong></h2>
<br>    

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $contausuario->id }}</li>
        <li class="list-group-item"><b>Conta:</b> {{ $contausuario->conta->nome ?? '' }}</li>
        <li class="list-group-item"><b>Usuário:</b> {{ $contausuario->usuario->name ?? '' }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $contausuario->user->name ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('contausuarios.edit',$contausuario->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('contausuarios.destroy', $contausuario) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta x Usuário?');">Deletar</button>
        </form>
    </div>
</div>
@endcan
@stop
