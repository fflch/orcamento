@extends('master')
@section('title')
    Lançamentos
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Lançamentos</strong></h2>
    @include('partials.mostra_ano')
</div>    
<br>
<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/lancamentos">
            @csrf
            <div class="row">
                <div class="col-sm input-group">
                    <select class="contas_select form-control" name="conta_id" tabindex="1" onchange="this.form.submit()">
                        <option value=" ">[ Busca por Conta ]</option>
                        @foreach($lista_contas_ativas as $lista_conta_ativa)
                            <option value="{{ $lista_conta_ativa->id }}"
                            @if(old('conta_id') == $lista_conta_ativa->id)
                                {{'selected'}}
                            @endif>
                            {{ $lista_conta_ativa->nome }} ({{ $lista_conta_ativa->descricao}})
                            </option>
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/lancamentos" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group col-md-2" align="right">
        <a href="{{ route('lancamentos.create') }}" class="btn btn-success"><strong>Adicionar Lançamento</strong></a>
    </div>
</div>
<div class="table-responsive">
    <p>{{ $lancamentos->links() }}</p>
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
                <tr>
                    <td align="left">{{ $lancamento->data }}</td>
                    <td align="left">{{ $lancamento->descricao }}</td>
                    <td align="left">{{ $lancamento->observacao }}</td>
                    <td align="left">{{ $lancamento->ficorcamentaria_id }}</td>
                    <td>{{ $lancamento->receita }}</td>
                    @if($lancamento->debito != 0.00)
                        <td>{{ $lancamento->debito }}</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                    @if($lancamento->credito != 0.00)
                        <td>{{ number_format($lancamento->credito_raw, 2, ',', '.') }}</td>
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
    <p>{{ $lancamentos->links() }}</p>
</div>
@endsection
@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.contas_select').select2();
        });
    </script>
@stop
