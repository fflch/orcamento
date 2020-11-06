@extends('master')

@section('content_header')
    <h1>Cadastrar Ficha Orçamentária</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-group">
<label>
<p><a href="{{ route('ficorcamentarias.create') }}" class="btn btn-success">
    Adicionar Ficha Orçamentária
</a></p>
</label>

<label>
<form method="get" action="/ficorcamentarias">
  <div class="row">
    <div class=" col-sm input-group">
      <input size="82%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="Busca por Deescrição">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-success"> Buscar </button>
      </span>
    </div>
  </div>
</form>
</label>

</div>

<div class="table-responsive">
<p>{{ $ficorcamentarias->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="5%" align="center">#</th>
                <th width="25%" align="left">Dotação</th>
                <th width="30%" align="left">Descrição</th>
                <th width="10%" align="left">Débito</th>
                <th width="10%" align="center">Crédito</th>
                <th width="20%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ficorcamentarias as $ficorcamentaria)
            <tr>
                <td align="center">{{ $ficorcamentaria->id }}</td>
                <td align="left"><a href="/ficorcamentarias/{{ $ficorcamentaria->id }}">{{ $ficorcamentaria->dotacao->dotacao ?? '' }}</a></td>
                <td align="left">{{ $ficorcamentaria->descricao }}</td>
                <td align="right">{{ $ficorcamentaria->debito }}</td>
                <td align="right">{{ $ficorcamentaria->credito }}</td>

                <td align="center">
                  <a class="btn btn-warning" href="/ficorcamentarias/{{$ficorcamentaria->id}}/edit">Editar</a>
                </td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a ficha orçamentária?');">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $ficorcamentarias->links() }}</p>   
</div>
@stop