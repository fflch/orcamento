@extends('master')

@section('content_header')
    <h1>Cadastrar Dotação Orçamentária</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<a href="{{ route('dotorcamentarias.create') }}" class="btn btn-success">
    Adicionar Dotação Orçamentária
</a>

<div class="table-responsive">
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="5%" align="center">#</th>
                <th width="10%" align="left">Dotação</th>
                <th width="10%" align="center">Grupo</th>
                <th width="20%" align="center">Descrição do Grupo</th>
                <th width="10%" align="center">Item</th>
                <th width="25%" align="left">Descrição do Item</th>  
                <th width="5%" align="center">Receita</th>                              
                <th width="15%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dotorcamentarias as $dotorcamentaria)
            <tr>
                <td align="center" valign="middle">{{ $dotorcamentaria->id }}</td>
                <td align="left"><a href="/dotorcamentarias/{{ $dotorcamentaria->id }}">{{ $dotorcamentaria->dotacao }}</a></td>
                <td align="center">{{ $dotorcamentaria->grupo }}</td>
                <td align="left">{{ $dotorcamentaria->descricaogrupo }}</td>
                <td align="left">{{ $dotorcamentaria->item }}</td>
                <td align="left">{{ $dotorcamentaria->descricaoitem }}</td>
                <td align="center" valign="middle">
                    @if ($dotorcamentaria->receita == 1)
                      X
                    @endif</td>
                <td align="center">
                    <a href="{{action('DotOrcamentariaController@edit', $dotorcamentaria->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td align="center">
                    <form action="{{action('DotOrcamentariaController@destroy', $dotorcamentaria->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop