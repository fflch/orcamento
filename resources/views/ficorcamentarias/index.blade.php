@extends('master')

@section('title')
    Fichas Orçamentárias
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Fichas Orçamentárias</strong></h2>
</div>
<br>    

<div class="form-row">
    <div class="form-group col-md-10">
        <label>
            <form method="get" action="/ficorcamentarias">
            @csrf
            <div class="row">
                <div class="col-sm input-group">

                    <input size="100%" list="dotacoes" name="dotacao_id" id="dotacao_id" class="form-control" value="{{ Request()->dotacao_id}}" placeholder="[ Busca por Dotação ]">
                    <datalist id="dotacoes">
                        @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
                            <option value="{{ $lista_dotorcamentaria->id }}">{{ $lista_dotorcamentaria->dotacao }}
                        @endforeach
                    </datalist>

                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                            <a class="btn btn-danger" href="/ficorcamentarias" title="Limpar a Busca"><strong>X</strong></a>
                        </span>
                </div>
            </div>
            </form>
        </label>
    </div>
    <div class="form-group col-md-2" align="right">
        <label>
            <p><a href="{{ route('ficorcamentarias.create') }}" class="btn btn-success"><strong>Adicionar Ficha Orçamentária</strong></a></p>
        </label>
    </div>
</div>

<div class="table-responsive">
<p>{{ $ficorcamentarias->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="5%" align="left">Dotação</th>
                <th width="10%" align="left">Data</th>
                <th width="47%" align="left">Descrição</th>
                <th width="7%" align="center">CP</th>
                <th width="7%" align="center">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($ficorcamentarias as $ficorcamentaria)
            <tr>
                <td align="left"><a href="/ficorcamentarias/{{ $ficorcamentaria->id }}">{{ $ficorcamentaria->dotacao->dotacao ?? '' }}</a></td>
                <td align="left">{{ $ficorcamentaria->data }}</td>
                <td align="left">{{ $ficorcamentaria->descricao }}</td>
                <td align="left">{{ $ficorcamentaria->ficorcamentaria_id }}</td>
                @if($ficorcamentaria->debito != 0.00)
                    <td align="right">{{ number_format($ficorcamentaria->debito, 2, ',', '.') }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                @if($ficorcamentaria->credito != 0.00)
                    <td align="right">{{ number_format($ficorcamentaria->credito, 2, ',', '.') }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                <td align="right">{{ $ficorcamentaria->saldo }}</td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/ficorcamentarias/{{$ficorcamentaria->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Ficha Orçamentária?');">Deletar</button>
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
<p>{{ $ficorcamentarias->links() }}</p>
</div>
@stop
