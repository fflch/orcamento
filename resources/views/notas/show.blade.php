@extends('master')

@section('title')
    Nota: {{ $nota->texto }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2></strong>Nota: {{ $nota->texto }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $nota->id }}</li>
        <li class="list-group-item"><b>Tipo de Conta:</b> {{ $nota->tipoconta->descricao ?? '' }}</li>
        <li class="list-group-item"><b>Texto:</b> {{ $nota->texto }}</li>
        <li class="list-group-item"><b>Tipo:</b> {{ $nota->tipo }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $nota->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $nota->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $nota->updated_at ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
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
@endcan
@stop
