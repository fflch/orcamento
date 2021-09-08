@extends('master')

@section('title')
    Notas
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-group">
<label>
<p><a href="{{ route('notas.create') }}" class="btn btn-success">Adicionar Nota</a></p>
</label>

<label>
<form method="get" action="/notas">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="88%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Texto ]">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success">Buscar</button>
      </span>
    </div>
  </div>
</form>
</label>
</div>

<div class="table-responsive">
<p>{{ $notas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="5%" align="center">&nbsp;</th>
                <th width="40%" align="left">Tipo de Conta</th>
                <th width="40%" align="left">Texto</th>
                <th width="5%" align="center">Tipo</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">Ações</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($notas as $nota)
            <tr>
                <td align="center">{{ $nota->id }}</td>
                <td align="left">{{ $nota->tipoconta->descricao ?? '' }}</td>
                <td align="left"><a href="/notas/{{ $nota->id }}">{{ $nota->texto }}</a></td>
                <td align="left">{{ $nota->tipo }}</td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/notas/{{$nota->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('notas.destroy', $nota) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Nota?');">Deletar</button>
                    </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $notas->links() }}</p>   
</div>
@stop
