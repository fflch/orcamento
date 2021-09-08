@extends('master')

@section('title')
    Dotação Orçamentária: {{ $dotorcamentaria->dotacao }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<h2><strong>Dotação Orçamentária: {{ $dotorcamentaria->dotacao }}</strong></h2>
<br>
    
<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $dotorcamentaria->id }}</li>
        <li class="list-group-item"><b>Dotação:</b> {{ $dotorcamentaria->dotacao }}</li>
        <li class="list-group-item"><b>Grupo:</b> {{ $dotorcamentaria->grupo }}</li>
        <li class="list-group-item"><b>Descrição do Grupo:</b> {{ $dotorcamentaria->descricaogrupo }}</li>
        <li class="list-group-item"><b>Item:</b> {{ $dotorcamentaria->item }}</li>
        <li class="list-group-item"><b>Descrição do Item:</b> {{ $dotorcamentaria->descricaoitem }}</li>
        <li class="list-group-item"><b>Receita:</b>@if ($dotorcamentaria->receita == 1) [ x ] @else [ &nbsp; ] @endif </li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $dotorcamentaria->user->name ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Criação:</b> {{ $dotorcamentaria->created_at ?? '' }}</li>
        <li class="list-group-item"><b>Data/Hora da Última Modificação:</b> {{ $dotorcamentaria->updated_at ?? '' }}</li>
    </ul>
</div>
@can('Administrador')
<br>
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('dotorcamentarias.edit',$dotorcamentaria->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('dotorcamentarias.destroy', $dotorcamentaria) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Dotação Orçamentária?');">Deletar</button>
        </form>
    </div>
</div>
@endcan
@stop
