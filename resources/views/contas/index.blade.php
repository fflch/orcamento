@extends('master')

@section('content_header')
    <h1>Cadastrar Conta</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-group">
<label>
<p><a href="{{ route('contas.create') }}" class="btn btn-success">
    Adicionar Conta
</a></p>
</label>
<label>
<form method="get" action="/contas">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="88%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="Busca por Nome">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"> Buscar </button>
      </span>
    </div>
  </div>
</form>
</label>
</div>

<div class="table-responsive">
<p>{{ $contas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="10%" align="center">#</th>
                <th width="25%" align="left">Tipo de Conta</th>
                <th width="25%" align="left">Área</th>
                <th width="25%" align="left">Nome</th>
                <th width="10%" align="center">Ativo</th>
                <th width="20%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contas as $conta)
            <tr>
                <td align="center">{{ $conta->id }}</td>
                <td align="left">{{ $conta->tipoconta->descricao ?? '' }}</td>
                <td align="left">{{ $conta->area->nome ?? '' }}</td>
                <td align="left"><a href="/contas/{{ $conta->id }}">{{ $conta->nome }}</a></td>

                <td align="center">
                    @if ($conta->ativo == 1)
                      X
                    @endif</td>
                <td align="center">
                  <a class="btn btn-warning" href="/contas/{{$conta->id}}/edit">Editar</a>
                    
                </td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('contas.destroy', $conta) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta?');">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $contas->links() }}</p>   
</div>
@stop