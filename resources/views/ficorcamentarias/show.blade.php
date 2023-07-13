@extends('master')
@section('title')
    Ficha Orçamentária: {{ $ficorcamentaria->dotacao->dotacao }}
@endsection
@section('content')
<div class="card p-3">
    @include('messages.flash')
    @include('messages.errors')
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
<br>
    <div class="form-row">
        <div class="form-group col-md-8">
            <a href="{{ url()->previous() }}" class="btn btn-info">Voltar</a>
            <a href="{{ route('ficorcamentarias.edit',$ficorcamentaria->id) }}" class="btn btn-warning">Editar</a>
        </div>
        <div class="form-group col-md-4" align="right">
            <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir Ficha Orçamentária?');">Deletar</button>
            </form>
        </div>
    </div>
</div>
<br>
@can('Administrador')
<div class="border rounded bg-light">
    <br>
    <h3 class="ml-2 mt-2">Adicionar Contra-Partida da Ficha Orçamentária</h3>
    <div class="p-4">
        <form method="POST" action="/ficorcamentarias/{{ $ficorcamentaria->id }}/cpfo/storeCpfo">
        @csrf
        @include('ficorcamentarias.formcp')
        </form>
    </div>
</div>
<br>
<div class="card p-3">
    <div class="form-group col-md-4"><b>Contra-partidas cadastradas:</b></div>
    <p>{{ $lancamentos->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="10%" align="left">Data</th>
                <th width="47%" align="left">Descrição</th>
                <th width="7%" align="center">CP</th>
                <th width="7%" align="center">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($lancamentos as $lancamento)
                <tr>
                    <td align="left">{{ $lancamento->data }}</td>
                    <td align="left">{{ $lancamento->descricao }}</td>
                    <td>{{ $lancamento->ficorcamentaria_id }}</td>
                    @if($lancamento->debito != 0.00)
                        <td>{{ number_format($lancamento->debito_raw, 2, ',', '.') }}</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                    @if($lancamento->credito != 0.00)
                        <td>{{ number_format($lancamento->credito_raw, 2, ',', '.') }}</td>
                    @else
                        <td align="right">&nbsp;</td>
                    @endif
                    <td>{{ $lancamento->saldo }}</td>
                    @can('Administrador')
                    <td align="center">
                        <form method="post" role="form" action="{{ route('lancamentos.destroy', $lancamento) }}" >
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Contra-partida?');">Excluir</button>
                        </form>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endcan
@stop
