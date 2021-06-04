@extends('master')

@section('title')
    Unidade: {{ $unidade->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2></strong>Unidade: {{ $unidade->nome }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $unidade->id }}</li>
        <li class="list-group-item"><b>Número:</b> {{ $unidade->numero }}</li>
        <li class="list-group-item"><b>Nome:</b> {{ $unidade->nome }}</li>
        <li class="list-group-item"><b>Departamento:</b> {{ $unidade->departamento }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $unidade->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $unidade->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $unidade->updated_at ?? '' }}</li>
    </ul>
</div>
@can('admin')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('unidades.edit',$unidade->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
@endcan
@stop
