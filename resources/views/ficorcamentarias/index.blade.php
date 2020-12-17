@extends('master')

@section('title')
    Fichas Orçamentárias
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="form-row">
    <div class="form-group col-md-2">
        <label>
            <p><a href="{{ route('ficorcamentarias.create') }}" class="btn btn-success">Adicionar Ficha Orçamentária</a></p>
        </label>
    </div>
    <div class="form-group col-md-10">
        <label>
            <form method="get" action="/ficorcamentarias">
                <!--div class="row"-->
                    <div class="col-sm input-group">
                        <input size="82%" type="text" class="form-control" name="busca" value="{{ Request()->busca}}" placeholder="[ Busca por Descrição ]">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-success"> Buscar </button>
                        </span>
                    </div>
                <!--/div-->
            </form>
        </label>
    </div>
</div>

<div class="table-responsive">
<p>{{ $ficorcamentarias->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr align="center">
                <th width="5%" align="center">#</th>
                <th width="5%" align="left">Dotação</th>
                <th width="50%" align="left">Descrição</th>
                <th width="10%" align="center">Débito</th>
                <th width="10%" align="center">Crédito</th>
                <th width="10%" align="center">Saldo</th>
                <th width="10%" align="center" colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ficorcamentarias as $ficorcamentaria)
            <tr>
                <td align="center">{{ $ficorcamentaria->id }}</td>
                <td align="left"><a href="/ficorcamentarias/{{ $ficorcamentaria->id }}">{{ $ficorcamentaria->dotacao->dotacao ?? '' }}</a></td>
                <td align="left">{{ $ficorcamentaria->descricao }}</td>
                @if($ficorcamentaria->debito != 0.00)
                    <td align="right">{{ $ficorcamentaria->debito }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                @if($ficorcamentaria->credito != 0.00)
                    <td align="right">{{ $ficorcamentaria->credito }}</td>
                @else
                    <td align="right">&nbsp;</td>
                @endif
                <td align="right">{{ $ficorcamentaria->saldo }}</td>
                <td align="center"><a class="btn btn-warning" href="/ficorcamentarias/{{$ficorcamentaria->id}}/edit">Editar</a></td>
                <td align="center">
                    <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Ficha Orçamentária?');">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">&nbsp;</td>
                <td align="right"><font color="red"><strong>Total Débito</strong></font></td>
                <td align="right"><font color="blue"><strong>Total Crédito</strong></font></td>
                <td colspan="3">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <p>{{ $ficorcamentarias->links() }}</p>   
</div>
@stop
