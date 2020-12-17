@extends('master')

@section('title')
    Nota: {{ $nota->texto }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('notas.edit',$nota->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('notas.destroy', $nota) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Nota?');">Deletar</button>
        </form>
    </div>
</div>
<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $nota->id }}</li>
        <li class="list-group-item"><b>Tipo de Conta:</b> {{ $nota->tipoconta->descricao ?? '' }}</li>
        <li class="list-group-item"><b>Texto:</b> {{ $nota->texto }}</li>
        <li class="list-group-item"><b>Tipo:</b> {{ $nota->tipo }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $nota->user->name ?? '' }}</li>
    </ul>
</div>
@stop
