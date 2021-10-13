@extends('master')

@section('title')
    Contas x Usuários
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
<h2><strong>Contas x Usuários</strong></h2>
</div>
<br> 

<div class="form-row">
<div class="form-group col-md-10">
<label>
<form method="get" action="/contausuarios">
@csrf
  <div class="row">
    <div class=" col-sm input-group">
      <input size="100%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Nome ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
        <a class="btn btn-danger" href="/contausuarios" title="Limpar a Busca"><strong>X</strong></a>
      </span>
    </div>
  </div>
</form>
</label>
</div>
<div class="form-group col-md-2" align="right">
<label>
<p><a href="{{ route('contausuarios.create') }}" class="btn btn-success"><strong>Adicionar Conta x Usuário</strong></a></p>
</label>
</div>
</div>

<div class="table-responsive">
<p>{{ $contausuarios->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="45%" align="left">Usuário</th>
                <th width="45%" align="left">Conta</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($contausuarios as $contausuario)
            <tr>
                <td align="left">{{ $contausuario->usuario->name ?? '' }}</td>
                <td align="left">{{ $contausuario->conta->nome ?? '' }}</td>
                <td align="center"><a class="btn btn-secondary" href="/contausuarios/{{$contausuario->id}}">Ver</a></td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/contausuarios/{{$contausuario->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('contausuarios.destroy', $contausuario) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta x Usuário?');">Deletar</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $contausuarios->links() }}</p>   
</div>
@stop
