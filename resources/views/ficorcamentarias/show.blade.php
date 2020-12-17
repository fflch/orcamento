@extends('master')

@section('title')
    Ficha Orçamentária: {{ $ficorcamentaria->dotacao->dotacao }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ route('ficorcamentarias.edit',$ficorcamentaria->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-1">
        <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir Ficha Orçamentária?');">Deletar</button>
        </form>
    </div>
</div>
<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>ID:</b> {{ $ficorcamentaria->id }}</li>
        <li class="list-group-item"><b>Movimento:</b> {{ $ficorcamentaria->movimento->ano ?? ''}}</li>
        <li class="list-group-item"><b>Dotacao:</b> {{ $ficorcamentaria->dotacao->dotacao ?? '' }}</li>
        <li class="list-group-item"><b>Empenho:</b> {{ $ficorcamentaria->empenho }}</li>
        <li class="list-group-item"><b>Descrição:</b> {{ $ficorcamentaria->descricao }}</li>
        <li class="list-group-item"><b>Débito:</b> @if($ficorcamentaria->debito != 0.00) {{ $ficorcamentaria->debito }} @endif</li>
        <li class="list-group-item"><b>Crédito:</b> @if($ficorcamentaria->credito != 0.00) {{ $ficorcamentaria->credito }} @endif</li>
        <li class="list-group-item"><b>Saldo:</b> {{ $ficorcamentaria->saldo }}</li>
        <li class="list-group-item"><b>Observação:</b> {{ $ficorcamentaria->observacao }}</li>
        <li class="list-group-item"><b>Cadastrado/Alterado por:</b> {{ $ficorcamentaria->user->name ?? '' }}</li>
    </ul>
</div>
@stop
