@extends('master')

@section('title')
    Usuários
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Usuários</strong></h2>
</div>
<br>    

<label>
<form method="get" action="/usuarios">
@csrf
  <div class="row">
    <div class=" col-sm input-group">
      <input size="100%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Nome ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
        <a class="btn btn-danger" href="/usuarios" title="Limpar a Busca"><strong>X</strong></a>
      </span>
    </div>
  </div>
</form>
</label>
</div>

<div class="table-responsive">
<p>{{ $usuarios->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="10%" align="left">Número USP</th>
                <th width="45%" align="left">Nome</th>
                <th width="25%" align="left">E-mail</th>
                <th width="10%" align="left">Perfil</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td align="left">{{ $usuario->codpes }}</td>
                <td align="left">{{ $usuario->name }}</td>
                <td align="left">{{ $usuario->email }}</td>
                <td align="left">{{ $usuario->perfil }}</td>
                <td align="center"><a class="btn btn-secondary" href="/usuarios/{{$usuario->id}}">Ver</a></td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/usuarios/{{$usuario->id}}/edit">Editar</a></td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $usuarios->links() }}</p>
</div>
@stop
