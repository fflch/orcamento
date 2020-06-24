@extends('master')

@section('content_header')
    <h1>Cadastrar Área</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<a href="{{ route('areas.create') }}" class="btn btn-success">
    Adicionar Área
</a>

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
                    <a href="{{action('AreaController@edit', $area->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td align="center">
                    <form action="{{action('AreaController@destroy', $area->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $areas->links() }}</p>
</div>
@stop