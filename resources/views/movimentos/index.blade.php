@extends('master')

@section('content_header')
    <h1>Cadastrar Movimento</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<a href="{{ route('movimentos.create') }}" class="btn btn-success">
    Adicionar Movimento
</a>

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
                    <a href="{{action('MovimentoController@edit', $movimento->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td align="center">
                    <form action="{{action('MovimentoController@destroy', $movimento->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $movimentos->links() }}</p>   
</div>
@stop