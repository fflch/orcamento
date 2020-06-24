@extends('master')

@section('content_header')
    <h1>Cadastrar Tipo de Conta</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<a href="{{ route('tipocontas.create') }}" class="btn btn-success">
    Adicionar Tipo de Conta
</a>

<div class="table-responsive">
<p>{{ $tipocontas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="10%" align="center">#</th>
                <th width="50%" align="left">Descrição</th>
                <th width="10%" align="center">C.P.F.O.</th>
                <th width="10%" align="center">Balancete</th>
                <th width="20%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tipocontas as $tipoconta)
            <tr>
                <td align="center">{{ $tipoconta->id }}</td>
                <td align="left"><a href="/tipocontas/{{ $tipoconta->id }}">{{ $tipoconta->descricao }}</a></td>

                <td align="center">
                    @if ($tipoconta->cpfo == 1)
                      X
                    @endif 
                </td>

                <td align="center">
                    @if ($tipoconta->relatoriobalancete == 1)
                      X
                    @endif</td>
                <td align="center">
                    <a href="{{action('TipoContaController@edit', $tipoconta->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td align="center">
                    <form action="{{action('TipoContaController@destroy', $tipoconta->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $tipocontas->links() }}</p>
</div>
@stop