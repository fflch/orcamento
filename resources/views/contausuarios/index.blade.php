@extends('master')

@section('title')
    Contas x Usuários
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-group">
<label>
<p><a href="{{ route('contausuarios.create') }}" class="btn btn-success">Adicionar Conta x Usuário</a></p>
</label>
<label>
<form method="get" action="/contausuarios">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="80%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Nome ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">Buscar</button>
      </span>
    </div>
  </div>
</form>
</label>
</div>

<div class="table-responsive">
<p>{{ $contausuarios->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="5%" align="center">#</th>
                <th width="40%" align="left">Conta</th>
                <th width="45%" align="left">Usuário</th>
                <th width="10%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contausuarios as $contausuario)
            <tr>
                <td align="center"><a href="/contausuarios/{{ $contausuario->id }}">{{ $contausuario->id }}</a></td>
                <td align="left">{{ $contausuario->conta->nome ?? '' }}</td>
                <td align="left">{{ $contausuario->usuario->name ?? '' }}</td>
                <td align="center"><a class="btn btn-warning" href="/contausuarios/{{$contausuario->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('contausuarios.destroy', $contausuario) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta x Usuário?');">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $contausuarios->links() }}</p>   
</div>
@stop
