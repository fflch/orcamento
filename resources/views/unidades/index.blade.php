@extends('master')

@section('title')
    Unidade
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div class="card p-3">
<h2><strong>Unidade</strong></h2>
</div>
<br>    

<div class="table-responsive">
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="5%" align="left">Número</th>
                <th width="50%" align="left">Nome</th>
                <th width="35%" align="left">Departamento</th>
                @can('Administrador')
                <th width="10%" align="center" colspan="2">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($unidades as $unidade)
            <tr>
                <td align="center">{{ $unidade->numero }}</td>
                <td align="left">{{ $unidade->nome }}</td>
                <td align="left">{{ $unidade->departamento }}</td>
                <td align="center"><a class="btn btn-secondary" href="/unidades/{{$unidade->id}}">Ver</a></td>
                @can('Administrador')
                <td align="center"><a class="btn btn-warning" href="/unidades/{{$unidade->id}}/edit">Editar</a></td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
