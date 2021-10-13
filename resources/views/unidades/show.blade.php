@extends('master')

@section('title')
    Unidade: {{ $unidade->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Unidade: {{ $unidade->nome }}</strong></h2>
</div>
<br>

<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-1"><b>Número:</b> {{ $unidade->numero }}</div>
        <div class="form-group col-md-7"><b>Nome:</b> {{ $unidade->nome }}</div>
        <div class="form-group col-md-4"><b>Departamento:</b> {{ $unidade->departamento }}</div>
</div>        
        <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $unidade->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($unidade->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($unidade->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
<br>
<div class="card p-3">
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('unidades.edit',$unidade->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
</div>
</div>
</div>
@endcan
@stop
