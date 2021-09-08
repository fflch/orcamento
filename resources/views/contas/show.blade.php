@extends('master')

@section('title')
    Conta: {{ $conta->nome }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Conta: {{ $conta->nome }}</strong></h2>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
      <li class="list-group-item"><b>ID</b>: {{ $conta->id }}</li>
        <li class="list-group-item"><b>Tipo de Conta:</b> {{ $conta->tipoconta->descricao ?? '' }}</li>
        <li class="list-group-item"><b>Área:</b> {{ $conta->area->nome ?? '' }}</li>
        <li class="list-group-item"><b>Nome:</b> {{ $conta->nome }}</li>
        <li class="list-group-item"><b>E-mail:</b> {{ $conta->email }}</li>
        <li class="list-group-item"><b>Número:</b> {{ $conta->numero }}</li>
        <li class="list-group-item"><b>Ativo:</b>@if ($conta->ativo == 1) [ x ] @else [ &nbsp; ] @endif </li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $conta->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $conta->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $conta->updated_at ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('contas.edit',$conta->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('contas.destroy', $conta) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta?');">Deletar</button>
        </form>
    </div>
</div>
@endcan
@stop
