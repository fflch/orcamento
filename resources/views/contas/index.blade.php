@extends('master')
@section('title')
    Contas
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Contas</strong></h2>
</div>
<br>    
<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/contas">
            @csrf
            <div class="row">
                <div class=" col-sm input-group">
                    <select class="tipocontas_select form-control" name="tipoconta_id"  onchange="this.form.submit()" tabindex="1">
                        <option value=" ">[ Busca por Tipo de Conta ]</option>
                        @foreach($lista_tipos_contas as $lista_tipo_conta)
                            <option value="{{ $lista_tipo_conta->id }}"
                                @if(old('tipoconta_id') == $lista_tipo_conta->id)
                                    {{ 'selected' }}
                                @else
                                    {{(request()->tipoconta_id === $lista_tipo_conta->id ) ? 'selected' : ''}}
                                @endif>
                                {{ $lista_tipo_conta->descricao }}
                            </option>
                        @endforeach
                    </select>
                    &nbsp;OU&nbsp;       
                    <input size="100%" type="text" class="form-control" name="busca_nome" value="{{ request()->busca_nome }}" placeholder="[ Busca por Nome ]">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a href="/contas" class="btn btn-danger" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
        </div>
        <div class="form-group col-md-2" align="right">
            <p><a href="{{ route('contas.create') }}" class="btn btn-success"><strong>Adicionar Conta</strong></a></p>
        </div>
    </div>
</div>
<div class="table-responsive">
    <p>{{ $contas->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="30%" align="left">Nome</th>
                <th width="30%" align="left">Tipo de Conta</th>
                <th width="25%" align="left">Área</th>
                <th width="5%" align="center">Ativo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($contas as $conta)
                <tr>
                    <td align="left">{{ $conta->nome }}</td>
                    <td align="left">{{ $conta->tipoconta->descricao ?? '' }}</td>
                    <td align="left">{{ $conta->area->nome ?? '' }}</td>
                    <td align="left">@if ($conta->ativo == 1) [ x ] @else [ &nbsp; ] @endif</td>
                    <td align="left"><a class="btn btn-dark" href="/lancamentos_por_conta/{{$conta->id}}" title="Ver Lançamentos da Conta {{ $conta->nome }}">Lançamentos</a></a></td>

                    <td align="center"><a class="btn btn-secondary" href="/contas/{{$conta->id}}">Ver</a></td>
                    @can('Administrador')
                        <td align="center"><a class="btn btn-warning" href="/contas/{{$conta->id}}/edit">Editar</a></td>
                        <td align="center">
                            <form method="post" role="form" action="{{ route('contas.destroy', $conta) }}">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta?');">Excluir</button>
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>{{ $contas->links() }}</p>   
</div>
@endsection
@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.tipocontas_select').select2();
        });
    </script>
@stop
