@extends('master')
@section('title')
    Notas
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Notas</strong></h2>
</div>
<br>
<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/notas">
            @csrf
            <div class="row">
                <div class=" col-sm input-group">
                    <input size="100%" type="text" class="form-control" name="busca_texto" value="{{ request()->busca_texto }}" placeholder="[ Busca por Texto ]">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/notas" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group col-md-2" align="right">
        <p><a href="{{ route('notas.create') }}" class="btn btn-success"><strong>Adicionar Nota</strong></a></p>
    </div>
</div>
<div class="table-responsive">
    <p>{{ $notas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="80%" align="left">Texto</th>
                <th width="10%" align="center">Tipo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($notas as $nota)
            <tr>
                <td align="left">{{ $nota->texto }}</td>
                <td align="left">{{ $nota->tipo }}</td>
                <td align="center"><a class="btn btn-secondary" href="/notas/{{$nota->id}}">Ver</a></td>
                @can('Administrador')
                    <td align="center"><a class="btn btn-warning" href="/notas/{{$nota->id}}/edit">Editar</a></td>
                    <td align="center">
                        <form method="post" role="form" action="{{ route('notas.destroy', $nota) }}" >
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Nota?');">Excluir</button>
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
