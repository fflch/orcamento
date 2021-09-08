@extends('master')

@section('title')
    Área: {{ $area->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Área: {{ $area->nome }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $area->id }}</li>
        <li class="list-group-item"><b>Nome:</b> {{ $area->nome }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $area->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $area->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $area->updated_at ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
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
@endcan
@stop
