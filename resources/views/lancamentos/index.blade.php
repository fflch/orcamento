@extends('master')

@section('title')
    Lançamentos
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
    <div class="form-group col-md-10">
        <label>
            <form method="get" action="/lancamentos">
                    <div class="col-sm input-group">
                        <input size="100%" list="contas" name="conta_id" id="conta_id" class="form-control" value="{{ Request()->conta_id}}" placeholder="[ Busca por Conta ]">
                        <datalist id="contas">
                            @foreach($lista_contas as $lista_conta)
                            <option value="{{ $lista_conta->id }}">{{ $lista_conta->nome }}
                            @endforeach
                        </datalist>

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        </span>
                    </div>
            </form>
        </label>
    </div>
    <div class="form-group col-md-2" align="right">
        <label>
            <p><a href="{{ route('lancamentos.create') }}" class="btn btn-success"><strong>Adicionar Lançamento</strong></a></p>
        </label>
    </div>
</div>

<div class="table-responsive">
<p>{{ $lancamentos->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="left">
                <th width="25%" align="left">Conta</th>
                <th width="10%" align="left">Data</th>
                <th width="34%" align="left">Descrição</th>
                <th width="7%" align="left">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($lancamentos as $lancamento)
            <tr>
                <td align="left"><a href="/lancamentos/{{ $lancamento->id }}">{{ $lancamento->conta->nome ?? '' }}</a></td>
                <td align="left">{{ $lancamento->data }}</td>
                <td align="left">{{ $lancamento->descricao }}</td>
                @if($lancamento->debito != 0.00)
                    <td align="right">{{ number_format($lancamento->debito, 2, ',', '.') }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                
                @if($lancamento->credito != 0.00)
                    <td align="right">{{ number_format($lancamento->credito, 2, ',', '.') }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                <td align="right">{{ $lancamento->saldo }}</td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/lancamentos/{{$lancamento->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('lancamentos.destroy', $lancamento) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Lançamento?');">Deletar</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
            <tr>
                <td colspan="3">&nbsp;</td>
                <td align="right"><font color="red"><strong>{{ number_format($total_debito, 2, ',', '.') }}</strong></font></td>
                <td align="right"><font color="blue"><strong>{{ number_format($total_credito, 2, ',', '.') }}</strong></font></td>
                <td align="right"><font color="black"><strong>{{ number_format(($total_credito - $total_debito), 2, ',', '.') }}</strong></font></td>
                @can('Administrador')
                <td colspan="2">&nbsp;</td>
                @endcan
            </tr>
        </tbody>
    </table>
<p>{{ $lancamentos->links() }}</p>
</div>
@stop
