@extends('master')

@section('content_header')
    <h1>Cadastrar Área</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<p><a href="{{ route('areas.create') }}" class="btn btn-success">
    Adicionar Área
</a></p>

<form method="get" action="/areas">
@csrf
@method('patch')
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
<p>{{ $areas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="10%" align="center">#</th>
                <th width="50%" align="left">Nome</th>
                <th width="20%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
            <tr>
                <td align="center">{{ $area->id }}</td>
                <td align="left"><a href="/areas/{{ $area->id }}">{{ $area->nome }}</a></td>

                <td align="center">
                    <a class="btn btn-warning" href="/areas/{{$area->id}}/edit">Editar</a>
                </td>
                <td align="center">
                <form method="post" role="form" action="{{ route('areas.destroy', $area) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o registro?');">Deletar</button>
                </form>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $areas->links() }}</p>
</div>
@stop