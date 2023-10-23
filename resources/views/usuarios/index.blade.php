@extends('master')

@section('title')
    Usuários
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
    <h2><strong>Usuários</strong></h2>
</div>
<br>    
<div class="form-row">
    <div class="form-group col-md-12">
        <form method="get" action="/usuarios">
            @csrf
            <div class="row">
                <div class=" col-sm input-group">
                    <input size="100%" type="text" class="form-control" name="busca_nome" value="{{ request()->busca_nome }}" placeholder="[ Busca por Nome ]">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/usuarios" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <p>{{ $usuarios->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="10%" align="left">Número USP</th>
                <th width="45%" align="left">Nome</th>
                <th width="25%" align="left">E-mail</th>
                <th width="10%" align="left">Perfil</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td align="left">{{ $usuario->codpes }}</td>
                    <td align="left">{{ $usuario->name }}</td>
                    <td align="left">{{ $usuario->email }}</td>
                    <td align="left">{{ $usuario->perfil }}</td>
                    @can('Administrador')
                        <td align="center"><a class="btn btn-warning" href="/usuarios/{{$usuario->id}}/edit">Visualizar/Editar</a></td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $usuarios->links() }}</p>
</div>
@stop