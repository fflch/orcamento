@extends('master')

@section('title')
    Movimento: {{ $movimento->ano }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Movimento: {{ $movimento->ano }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $movimento->id }}</li>
        <li class="list-group-item"><b>Ano:</b> {{ $movimento->ano }}</li>
        <li class="list-group-item"><b>Concluído:</b>@if ($movimento->concluido == 1) [ x ] @else [ &nbsp; ] @endif </li>
        <li class="list-group-item"><b> Ativo:</b>@if ($movimento->ativo == 1) [ x ] @else [ &nbsp; ] @endif</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $movimento->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $movimento->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $movimento->updated_at ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('movimentos.edit',$movimento->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('movimentos.destroy', $movimento) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Movimento?');">Deletar</button>
        </form>
    </div>
</div>
@endcan
@stop
