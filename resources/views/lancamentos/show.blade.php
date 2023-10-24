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
@can('Administrador')
    <br>
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
<br>
<div class="border rounded bg-light">
    <br>
    <h3 class="ml-2 mt-2">Adicionar Percentuais</h3>
    <div class="p-4">
        <form method="POST" action="/lancamentos/{{$lancamento->id}}/percentual/storePercentual">
        @csrf
        @include('lancamentos.partials.percentual')
        </form>
    </div>
</div>
<br>
<div class="card p-3">
    <div class="form-group col-md-4"><b>Percentuais cadastrados:</b></div>
        <table class="table table-striped" border="0">
            <thead>
                <tr>
                    <th width="47%" align="left">Conta</th>
                    <th width="7%" align="center">Percentual</th>
                    @can('Administrador')
                        <th width="10%" align="center" colspan="3">&nbsp;</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach($lancamento->contas as $conta)
                    <tr>
                        <td align="left">{{ $conta->nome }}</td>
                        <td>{{ $conta->pivot->percentual }}</td>
                        @can('Administrador')
                        <td align="center">
                            <form method="post" role="form" action="/lancamentos/{{$lancamento->id}}/destroyPercentual" >
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <input type="hidden" name="percentual" value="{{ $conta->pivot->percentual }}">
                                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Percentual?');">Excluir</button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
