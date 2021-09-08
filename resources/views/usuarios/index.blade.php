@extends('master')

@section('title')
    Usuários
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<label>
<form method="get" action="/usuarios">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="88%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Nome ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">Buscar</button>
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
                <th width="5%" align="center">&nbsp;</th>
                <th width="5%" align="left">Número USP</th>
                <th width="45%" align="left">Nome</th>
                <th width="25%" align="left">E-mail</th>
                <th width="10%" align="left">Perfil</th>
                @can('Administrador')
                <th width="10%" align="center">Ações</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td align="center">{{ $usuario->id }}</td>
                <td align="center">{{ $usuario->codpes }}</td>
                <td align="left"><a href="/usuarios/{{ $usuario->id }}">{{ $usuario->name }}</a></td>
                <td align="left">{{ $usuario->email }}</td>
                <td align="left">{{ $usuario->perfil }}</td>

                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/usuarios/{{$usuario->id}}/edit">Editar</a></td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
