@extends('master')

@section('title')
    Tipos de Conta
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
<div class="form-group col-md-10">
<label>
<form method="get" action="/tipocontas">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="100%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Descrição ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
      </span>
    </div>
  </div>
</form>
</label>
</div>
<div class="form-group col-md-2" align="right">
<label>
<p><a href="{{ route('tipocontas.create') }}" class="btn btn-success"><strong>Adicionar Tipo de Conta</strong></a></p>
</label>
</div>
</div>

<div class="table-responsive">
<p>{{ $tipocontas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="80%">Descrição</th>
                <th width="5%">C.P.F.O.</th>
                <th width="5%">Balancete</th>
                @can('Administrador')
                <th width="10%" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($tipocontas as $tipoconta)
            <tr>
                <td align="left"><a href="/tipocontas/{{ $tipoconta->id }}">{{ $tipoconta->descricao }}</a></td>
                <td align="center">@if ($tipoconta->cpfo == 1) [ x ] @else [ &nbsp; ] @endif</td>
                <td align="center">@if ($tipoconta->relatoriobalancete == 1) [ x ] @else [ &nbsp; ] @endif</td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/tipocontas/{{$tipoconta->id}}/edit">Editar</a></td>
                <td align="center">
                <form method="post" role="form" action="{{ route('tipocontas.destroy', $tipoconta) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Tipo de Conta?');">Deletar</button>
                </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $tipocontas->links() }}</p>
</div>
@stop
