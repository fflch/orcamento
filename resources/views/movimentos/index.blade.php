@extends('master')

@section('content_header')
    <h1>Cadastrar Movimento</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<p><a href="{{ route('movimentos.create') }}" class="btn btn-success">
    Adicionar Movimento
</a></p>

<form method="get" action="/movimentos">
  <div class="row">
    <div class=" col-sm input-group">
      <input type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="Busca por Ano">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"> Buscar </button>
      </span>
    </div>
  </div>
</form>

<div class="table-responsive">
<p>{{ $movimentos->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="10%" align="center">#</th>
                <th width="50%" align="left">Ano</th>
                <th width="10%" align="center">Concluído</th>
                <th width="10%" align="center">Ativo</th>
                <th width="20%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimentos as $movimento)
            <tr>
                <td align="center">{{ $movimento->id }}</td>
                <td align="left"><a href="/movimentos/{{ $movimento->id }}">{{ $movimento->ano }}</a></td>

                <td align="center">
                    @if ($movimento->concluido == 1)
                      X
                    @endif 
                </td>

                <td align="center">
                    @if ($movimento->ativo == 1)
                      X
                    @endif</td>
                <td align="center">
                  <a class="btn btn-warning" href="/movimentos/{{$movimento->id}}/edit">Editar</a>
                    
                </td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('movimentos.destroy', $movimento) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o registro?');">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $movimentos->links() }}</p>   
</div>
@stop