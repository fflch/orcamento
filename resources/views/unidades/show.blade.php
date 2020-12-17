@extends('master')

@section('title')
    Unidade: {{ $unidade->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('unidades.edit',$unidade->id) }}" class="btn btn-warning">Editar</a>
    </div>
</div>
<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $unidade->id }}</li>
        <li class="list-group-item"><b>Número:</b> {{ $unidade->numero }}</li>
        <li class="list-group-item"><b>Nome:</b> {{ $unidade->nome }}</li>
        <li class="list-group-item"><b>Departamento:</b> {{ $unidade->departamento }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $unidade->user->name ?? '' }}</li>
    </ul>
</div>
@stop
