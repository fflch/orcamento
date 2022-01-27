@extends('master')
@section('title')
    Tipos de Conta
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Tipos de Contas</strong></h2>
</div>
<br>    
<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/tipocontas">
            @csrf
            <div class="row">
                <div class=" col-sm input-group">
                    <input size="100%" type="text" class="form-control" name="busca_descricao" value="{{ request()->busca_descricao }}" placeholder="[ Busca por Descrição ]">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/tipocontas" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group col-md-2" align="right">
        <p><a href="{{ route('tipocontas.create') }}" class="btn btn-success"><strong>Adicionar Tipo de Conta</strong></a></p>
    </div>
</div>
<div class="table-responsive">
<p>{{ $tipocontas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="75%">Descrição</th>
                <th width="5%">C.P.F.O.</th>
                <th width="5%">Balancete</th>
                <th width="5%">&nbsp;</th>
                @can('Administrador')
                    <th width="10%" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($tipocontas as $tipoconta)
                <tr>
                    <td align="left">{{ $tipoconta->descricao }}</td>
                    <td align="center">@if ($tipoconta->cpfo == 1) [ x ] @else [ &nbsp; ] @endif</td>
                    <td align="center">@if ($tipoconta->relatoriobalancete == 1) [ x ] @else [ &nbsp; ] @endif</td>
                    <td align="left"><a class="btn btn-dark" href="/contas_por_tipo_de_conta/{{$tipoconta->id}}" title="Ver Contas do Tipo de Conta {{ $tipoconta->descricao }}">Contas</a></a></td>
                    <td align="center"><a class="btn btn-secondary" href="/tipocontas/{{$tipoconta->id}}">Ver</a></td>
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
