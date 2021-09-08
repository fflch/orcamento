@extends('master')

@section('title')
    Lançamentos
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-group">
<label>
<p><a href="{{ route('lancamentos.create') }}" class="btn btn-success">Adicionar Lançamento</a></p>
</label>
<label>
<form method="get" action="/lancamentos">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="88%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Descrição ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"> Buscar </button>
      </span>
    </div>
  </div>
</form>
</label>
</div>

<div class="table-responsive">
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="5%" align="center">#</th>
                <th width="20%" align="left">Conta</th>
                <th width="35%" align="left">Descrição</th>
                <th width="10%" align="left">Débito</th>
                <th width="10%" align="center">Crédito</th>
                <th width="10%" align="center">Saldo</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">Ações</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($lancamentos as $lancamento)
            <tr>
                <td align="center">{{ $lancamento->id }}</td>
                <td align="left"><a href="/lancamentos/{{ $lancamento->id }}">{{ $lancamento->conta->nome ?? '' }}</a></td>
                <td align="left">{{ $lancamento->descricao }}</td>
                @if($lancamento->debito != 0.00)
                    <td align="right">{{ $lancamento->debito }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                
                @if($lancamento->credito != 0.00)
                    <td align="right">{{ $lancamento->credito }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                <td align="right">{{ number_format(floatval($lancamento->credito) - floatval($lancamento->debito), 2, ',', ' ') }}</td>
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
            <td colspan="3" align="right"><font color="black"><strong>{{ number_format(($total_credito - $total_debito), 2, ',', '.') }}</strong></font></td>
            </tr>
        </tbody>
    </table>
</div>
@stop
