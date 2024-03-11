@extends('master')
@section('title')
    Lançamentos
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Lançamentos - Conta: {{ $conta->nome }}</strong></h2>
    @include('partials.mostra_ano')
</div>
<br>
<div class="table-responsive">
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="10%" align="left">Data</th>
                <th width="34%" align="left">Descrição</th>
                <th width="34%" align="left">Observação</th>
                <th width="7%" align="left">CP</th>
                <th width="7%" align="left">REC</th>
                <th width="7%" align="left">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($lancamentos as $lancamento)
                @foreach($lancamento->contas as $conta)
                    <tr>
                        <td align="left">{{ $lancamento->data }}</td>
                        <td align="left">{{ $lancamento->descricao }}</td>
                        <td align="left">{{ $lancamento->observacao }}</td>
                        <td align="left">{{ $lancamento->ficorcamentaria_id }}</td>
                        <td>{{ $lancamento->receita }}</td>
                        @if($lancamento->debito != 0.00)
                            <td>{{ number_format((float)($lancamento->debito_raw * $conta->pivot->percentual/100),2, ',', '.') }}</td>
                        @else
                            <td>&nbsp;</td>
                        @endif
                        @if($lancamento->credito != 0.00)
                        <td>{{ number_format((float)($lancamento->credito_raw * $conta->pivot->percentual/100),2, ',', '.') }}</td>
                        @else
                            <td align="right">&nbsp;</td>
                        @endif
                        <td>{{ $lancamento->saldo }}</td>
                        <td align="center"><a class="btn btn-secondary" href="/lancamentos/{{$lancamento->id}}">Ver</a></td>
                        @can('Administrador')
                            <td align="center"><a class="btn btn-warning" href="/lancamentos/{{$lancamento->id}}/edit">Editar</a></td>
                            <td align="center">
                                <form method="post" role="form" action="{{ route('lancamentos.destroy', $lancamento) }}" >
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Lançamento?');">Excluir</button>
                                </form>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            @endforeach
            </tbody>
    </table>
</div>
@include('lancamentos.partials.saldo')
@endsection
@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.contas_select').select2();
        });
    </script>
@stop
