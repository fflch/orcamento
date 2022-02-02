@extends('master')
@section('title')
    Dotações Orçamentárias - {{ $dotorcamentaria->dotacao }}
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Dotações Orçamentárias - {{ $dotorcamentaria->dotacao }}</strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-2"><b>Dotação:</b> {{ $dotorcamentaria->dotacao }}</div>
        <div class="form-group col-md-2"><b>Grupo:</b> {{ $dotorcamentaria->grupo }}</div>
        <div class="form-group col-md-8"><b>Descrição do Grupo:</b> {{ $dotorcamentaria->descricaogrupo }}</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">&nbsp;</div>
        <div class="form-group col-md-2"><b>Item:</b> {{ $dotorcamentaria->item }}</div>
        <div class="form-group col-md-6"><b>Descrição do Item:</b> {{ $dotorcamentaria->descricaoitem }}</div>
        <div class="form-group col-md-1"><b>Receita:</b>@if ($dotorcamentaria->receita == 1) [ x ] @else [ &nbsp; ] @endif </div>
        <div class="form-group col-md-1"><b>Ativo:</b>@if ($dotorcamentaria->ativo == 1) [ x ] @else [ &nbsp; ] @endif </div>
    </div>
    <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $dotorcamentaria->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($dotorcamentaria->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($dotorcamentaria->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
<br>
<div class="card p-3">
    <div class="form-row">
        <div class="form-group col-md-8">
            <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
            <a href="{{ route('dotorcamentarias.edit',$dotorcamentaria->id) }}" class="btn btn-warning">Editar</a>
        </div>
        <div class="form-group col-md-4" align="right">
            <form method="post" role="form" action="{{ route('dotorcamentarias.destroy', $dotorcamentaria) }}" >
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Dotação Orçamentária?');">Excluir</button>
            </form>
        </div>
    </div>
</div>
@endcan
@stop
