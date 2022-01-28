@extends('master')
@section('title')
    Notas - {{ $nota->texto }}
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Notas - {{ $nota->texto }}</strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-4"><b>Tipo de Conta:</b> {{ $nota->tipoconta->descricao ?? '' }}</div>
        <div class="form-group col-md-6"><b>Texto:</b> {{ $nota->texto }}</div>
        <div class="form-group col-md-2"><b>Tipo:</b> {{ $nota->tipo }}</div>
    </div>
    <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $nota->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($nota->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($nota->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
    <br>
    <div class="card p-3">
        <div class="form-row">
            <div class="form-group col-md-8">
                <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
                <a href="{{ route('notas.edit',$nota->id) }}" class="btn btn-warning">Editar</a>
            </div>
            <div class="form-group col-md-4" align="right">
                <form method="post" role="form" action="{{ route('notas.destroy', $nota) }}" >
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Nota?');">Excluir</button>
                </form>
            </div>
        </div>
    </div>
@endcan
@stop
