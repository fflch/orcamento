@extends('master')

@section('title')
    Movimentos
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Movimentos</strong></h2>
</div>
<br>

    <div class="form-row">

<div class="form-group col-md-10">
<label>
<form method="get" action="/movimentos">
@csrf
  <div class="row">
    <div class=" col-sm input-group">
      <input size="100%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Ano ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
        <a class="btn btn-danger" href="/movimentos" title="Limpar a Busca"><strong>X</strong></a>
      </span>
    </div>
  </div>
</form>
</label>
</div>

<div class="form-group col-md-2" align="right">
<label>
<p><a href="{{ route('movimentos.create') }}" class="btn btn-success"><strong>Adicionar Movimento</strong></a></p>
</label>
</div>

</div>

<div class="table-responsive">
<p>{{ $movimentos->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="80%" align="left">Ano</th>
                <th width="5%" align="center">Concluído</th>
                <th width="5%" align="center">Ativo</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($movimentos as $movimento)
            <tr>
                <td align="left"><a href="/movimentos/{{ $movimento->id }}">{{ $movimento->ano }}</a></td>
                <td align="center">@if ($movimento->concluido == 1) [ x ] @else [ &nbsp; ] @endif</td>
                <td align="center">@if ($movimento->ativo == 1) [ x ] @else [ &nbsp; ] @endif</td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/movimentos/{{$movimento->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('movimentos.destroy', $movimento) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Movimento?');">Deletar</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $movimentos->links() }}</p>   
</div>
@stop
