@extends('master')
@section('title')
    Usuários - {{ $usuario->name }}
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Usuários - {{ $usuario->name }}</strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-2"><b>Número USP:</b> {{ $usuario->codpes }}</div>
        <div class="form-group col-md-6"><b>Nome:</b> {{ $usuario->name }}</div>
        <div class="form-group col-md-2"><b>E-mail:</b> {{ $usuario->email }}</div>
        <div class="form-group col-md-2"><b>Perfil:</b> {{ $usuario->perfil }}</div>
    </div>
    <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $usuario->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($usuario->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($usuario->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
    <br>
    <div class="card p-3">
        <div class="form-row">
            <div class="form-group col-md-12">
                <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
                <a href="{{ route('usuarios.edit',$usuario->id) }}" class="btn btn-warning">Editar</a>
            </div>
        </div>
    </div>
@endcan
@stop
