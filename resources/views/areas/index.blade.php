@extends('master')

@section('title')
    Áreas
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
    <h2><strong>Áreas</strong></h2>
</div>
<br>    

<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/areas">
            @csrf
            <div class="row">
                <div class=" col-sm input-group">
                    <input size="100%" type="text" class="form-control" name="busca_nome" value="{{ request()->busca_nome }}" placeholder="[ Busca por Nome ]">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/areas" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group col-md-2" align="right">  
        <p><a href="{{ route('areas.create') }}" class="btn btn-success"><strong>Adicionar Área</strong></a></p>
    </div>
</div>

<div class="table-responsive">
    <p>{{ $areas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="90%" align="left">Nome</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
                <tr>
                    <td align="left">{{ $area->nome }}</td>
                    <td align="center"><a class="btn btn-secondary" href="/areas/{{$area->id}}">Ver</a></td>
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
