@extends('master')
@section('title')
    Área: {{ $area->nome }}
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Área: {{ $area->nome }}</strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-12"><b>Nome:</b> {{ $area->nome }}</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $area->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($area->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($area->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
<br>
<div class="card p-3">
    <div class="form-row">
        <div class="form-group col-md-8">
            <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
            @can('Administrador')
            <a href="{{ route('areas.edit',$area->id) }}" class="btn btn-warning">Editar</a>
        </div>
        <div class="form-group col-md-4" align="right">
            <form method="post" role="form" action="{{ route('areas.destroy', $area) }}" >
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Área?');">Excluir</button>
            </form>
            @endcan
        </div>
    </div>
</div>
@stop
