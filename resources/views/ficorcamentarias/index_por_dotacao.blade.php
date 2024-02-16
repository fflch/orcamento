@extends('master')
@section('title')
    Dotação: {{ $dotorcamentaria->dotacao }}
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Fichas Orçamentárias - Dotação {{ $dotorcamentaria->dotacao }}</strong></h2>
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
                <th width="7%" align="left">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($fichas as $ficha)
                <tr>
                    <td align="left">{{ $ficha->data }}</td>
                    <td align="left">{{ $ficha->descricao }}</td>
                    <td align="left">{{ $ficha->observacao }}</td>
                    @if($ficha->debito != 0.00)
                        <td>{{ $ficha->debito_raw }}</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                    @if($ficha->credito != 0.00)
                    <td>{{ $ficha->credito_raw }}</td>
                    @else
                        <td align="right">&nbsp;</td>
                    @endif
                    <td>{{ $ficha->saldo }}</td>
                    <td align="center"><a class="btn btn-secondary" href="/ficorcamentarias/{{$ficha->id}}">Ver</a></td>
                    @can('Administrador')
                        <td align="center"><a class="btn btn-warning" href="/ficorcamentarias/{{$ficha->id}}/edit">Editar</a></td>
                        <td align="center">
                            <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficha) }}" >
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Ficha?');">Excluir</button>
                            </form>
                        </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">&nbsp;</td>
                    <td><font color="red"><strong>{{ number_format($total_debito, 2, ',', '.') ?? '' }}</strong></font></td>
                    <td><font color="blue"><strong>{{ number_format($total_credito, 2, ',', '.') }}</strong></font></td>
                    <td>
                    @if(($total_credito - $total_debito) == 0.00)
                        <font color="black">
                    @elseif(($total_credito - $total_debito) > 0.00)
                        <font color="green">
                    @else
                        <font color="red">
                    @endif
                    <strong>{{ number_format(($total_credito - $total_debito), 2, ',', '.') }}</strong></font></td>
                    @can('Administrador')
                        <td colspan="3">&nbsp;</td>
                    @endcan
                </tr>
            </tfoot>
    </table>
</div>
@endsection
