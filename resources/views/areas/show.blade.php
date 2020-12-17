@extends('master')

@section('title')
    Área: {{ $area->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('areas.edit',$area->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('areas.destroy', $area) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Área?');">Deletar</button>
        </form>
    </div>
</div>
<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $area->id }}</li>
        <li class="list-group-item"><b>Nome:</b> {{ $area->nome }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $area->user->name ?? '' }}</li>
    </ul>
</div>
@stop
