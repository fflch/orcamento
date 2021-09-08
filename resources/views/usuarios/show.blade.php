@extends('master')

@section('title')
    Usuário: {{ $usuario->name }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2></strong>Usuário: {{ $usuario->name }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $usuario->id }}</li>
        <li class="list-group-item"><b>Número USP:</b> {{ $usuario->codpes }}</li>
        <li class="list-group-item"><b>Nome:</b> {{ $usuario->name }}</li>
        <li class="list-group-item"><b>E-mail:</b> {{ $usuario->email }}</li>
        <li class="list-group-item"><b>Perfil:</b> {{ $usuario->perfil }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $usuario->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $usuario->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $usuario->updated_at ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('usuarios.edit',$usuario->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endcan
@stop
