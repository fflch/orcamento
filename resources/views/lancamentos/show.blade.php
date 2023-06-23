@extends('master')
@section('title')
    Lançamentos
@endsection
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Lançamento: </strong></h2>
</div>
<br>
<div class="card p-4">
    <div class="form-row">
        <div class="form-group col-md-1"><b>Movimento:</b> {{ $lancamento->movimento->ano ?? ''}}</div>
        <div class="form-group col-md-1"><b>Grupo:</b> {{ $lancamento->grupo }}</div>
        <div class="form-group col-md-1"><b>Receita:</b>@if ($lancamento->receita == 1) [ x ] @else [ &nbsp; ] @endif</div>
        <div class="form-group col-md-2"><b>Empenho:</b> {{ $lancamento->empenho }}</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3"><b>Data:</b> {{ $lancamento->data }}</div>
        <div class="form-group col-md-9"><b>Descrição:</b> {{ $lancamento->descricao }}</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4"><b>Débito:</b> @if($lancamento->debito != 0.00) {{ $lancamento->debito }} @endif</div>
        <div class="form-group col-md-4"><b>Crédito:</b> @if($lancamento->credito != 0.00) {{ $lancamento->credito }} @endif</div>
        <div class="form-group col-md-4"><b>Saldo:</b> {{ $lancamento->saldo }}</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-10"><b>Observação:</b> {{ $lancamento->observacao }}</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3"><b>Percentuais:</b><br>
            @foreach($lancamento->contas as $conta)
            {{ $conta->pivot->percentual }}% - {{ $conta->nome }} <br>
            Valor em reais:
            @if($lancamento->debito != 0.00)            
            {{ ( (float) $conta->pivot->percentual *  (float) $lancamento->debito)/100 }} <br>
            @endif
            @if($lancamento->credito != 0.00)
            {{ ( (float) $conta->pivot->percentual *  (float) $lancamento->credito)/100 }} <br>
            @endif
            @endforeach
        </div>
    </div>
    <div class="form-row">        
        <div class="form-group col-md-4"><b>Cadastrado/Alterado por:</b> {{ $lancamento->user->name ?? '' }}</div>
        <div class="form-group col-md-4"><b>Criação:</b> {{ date_format($lancamento->created_at, 'd/m/Y H:i:s') ?? '' }}</div>
        <div class="form-group col-md-4"><b>Última Modificação:</b> {{ date_format($lancamento->updated_at, 'd/m/Y H:i:s') ?? '' }}</div>
    </div>
</div>
@can('Administrador')
    <br>
    <div class="card p-3">
        <div class="form-row">
            <div class="form-group col-md-8">
                <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
                <a href="{{ route('lancamentos.edit',$lancamento->id) }}" class="btn btn-warning">Editar</a>
            </div>
            <div class="form-group col-md-4" align="right">
                <form method="post" role="form" action="{{ route('lancamentos.destroy', $lancamento) }}" >
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Lançamento?');">Deletar</button>
                </form>
            </div>
        </div>    
    </div>
@endcan
@stop
