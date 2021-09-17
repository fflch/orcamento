@extends('master')

@section('title')
    Áreas
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
  <div class="form-group col-md-10">
    <label>
      <form method="get" action="/areas">
        @csrf
        @method('patch')
        <div class="row">
          <div class=" col-sm input-group">
            <input size="100%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Nome ]">
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
      <p><a href="{{ route('areas.create') }}" class="btn btn-success"><strong>Adicionar Área</strong></a></p>
    </label>
  </div>
</div>

<div class="table-responsive">
<p>{{ $areas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="90%" align="left">Nome</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
            <tr>
                <td align="left"><a href="/areas/{{ $area->id }}">{{ $area->nome }}</a></td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/areas/{{$area->id}}/edit">Editar</a></td>
                <td align="center">
                <form method="post" role="form" action="{{ route('areas.destroy', $area) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Área?');">Deletar</button>
                </form>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $areas->links() }}</p>
</div>
@stop
