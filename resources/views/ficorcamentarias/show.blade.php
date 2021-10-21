@extends('master')

@section('title')
    Ficha Orçamentária: {{ $ficorcamentaria->dotacao->dotacao }}
@endsection

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Ficha Orçamentária: {{ $ficorcamentaria->dotacao->dotacao }}</strong></h2>
</div>
<br>

<div class="card p-4">
<div class="form-row">
        <div class="form-group col-md-1"><b>Movimento:</b> {{ $ficorcamentaria->movimento->ano ?? ''}}</div>
        <div class="form-group col-md-2"><b>Dotacao:</b> {{ $ficorcamentaria->dotacao->dotacao ?? '' }}</div>
        <div class="form-group col-md-2"><b>Data:</b> {{ $ficorcamentaria->data }}</div>
        <div class="form-group col-md-2"><b>Empenho:</b> {{ $ficorcamentaria->empenho }}</div>

        <div class="form-group col-md-5"><b>Descrição:</b> {{ $ficorcamentaria->descricao }}</div>
</div>
        <div class="form-row">
        <div class="form-group col-md-4"><b>Débito:</b> @if($ficorcamentaria->debito != 0.00) {{ $ficorcamentaria->debito }} @endif</div>
        <div class="form-group col-md-4"><b>Crédito:</b> @if($ficorcamentaria->credito != 0.00) {{ $ficorcamentaria->credito }} @endif</div>
        <div class="form-group col-md-4"><b>Saldo:</b> {{ $ficorcamentaria->saldo }}</div>
    </div>
    <div class="form-row">

        <div class="form-group col-md-12"><b>Observação:</b> {{ $ficorcamentaria->observacao }}</div>
</div>
 <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $ficorcamentaria->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($ficorcamentaria->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($ficorcamentaria->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
<br>
<div class="card p-3">
<div class="form-row">
    <div class="form-group col-md-1">
        <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
        <a href="{{ route('ficorcamentarias.edit',$ficorcamentaria->id) }}" class="btn btn-warning">Editar</a>
    </div>
    <div class="form-group col-md-11" align="right">
        <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir Ficha Orçamentária?');">Deletar</button>
        </form>
    </div>
</div>
</div>
@endcan
@stop
