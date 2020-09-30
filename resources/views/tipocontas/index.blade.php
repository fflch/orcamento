@extends('master')

@section('content_header')
    <h1>Cadastrar Tipo de Conta</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<p><a href="{{ route('tipocontas.create') }}" class="btn btn-success">
    Adicionar Tipo de Conta
</a></p>

<form method="get" action="/tipocontas">
  <div class="row">
    <div class=" col-sm input-group">
      <input type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="Busca por Nome">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"> Buscar </button>
      </span>
    </div>
  </div>
</form>

<div class="table-responsive">
<p>{{ $tipocontas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="10%" align="center">#</th>
                <th width="50%" align="left">Descrição</th>
                <th width="10%" align="center">C.P.F.O.</th>
                <th width="10%" align="center">Balancete</th>
                <th width="20%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipocontas as $tipoconta)
            <tr>
                <td align="center">{{ $tipoconta->id }}</td>
                <td align="left"><a href="/tipocontas/{{ $tipoconta->id }}">{{ $tipoconta->descricao }}</a></td>

                <td align="center">
                    @if ($tipoconta->cpfo == 1)
                      X
                    @endif 
                </td>

                <td align="center">
                    @if ($tipoconta->relatoriobalancete == 1)
                      X
                    @endif</td>
                <td align="center">
                <a class="btn btn-warning" href="/tipocontas/{{$tipoconta->id}}/edit">Editar</a>
                </td>
                <td align="center">
                <form method="post" role="form" action="{{ route('tipocontas.destroy', $tipoconta) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o registro?');">Deletar</button>
                </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $tipocontas->links() }}</p>
</div>
@stop