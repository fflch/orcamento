@extends('master')
@section('title')
    Fichas Orçamentárias
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Fichas Orçamentárias</strong></h2>
    @include('partials.mostra_ano')
</div>
<br>    
<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/ficorcamentarias">
            @csrf
            <div class="row">
                <div class=" col-sm input-group">
                    <select class="dotacoes_select form-control" name="dotacao_id"  onchange="this.form.submit()" tabindex="1">
                        <option value=" ">[ Busca por Dotação ]</option>
                        @foreach($lista_dotorcamentarias as $lista_dotorcamentaria)
                            @if(old('dotacao_id') == '')
                                <option value="{{ $lista_dotorcamentaria->id }}"
                                {{ ( $lista_dotorcamentaria->id == request()->dotacao_id ) ? 'selected' : '' }}>
                                {{ $lista_dotorcamentaria->dotacao }}
                                </option>
                                @else
                                <option value="{{ $lista_dotorcamentaria->id }}">
                                {{ $lista_dotorcamentaria->id }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/ficorcamentarias" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group col-md-2" align="right">
        <p><a href="{{ route('ficorcamentarias.create') }}" class="btn btn-success"><strong>Adicionar Ficha Orçamentária</strong></a></p>
    </div>
</div>
<div class="table-responsive">
    <p>{{ $ficorcamentarias->appends($_GET)->links() }}</p>
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="5%" align="left">Dotação</th>
                <th width="10%" align="left">Data</th>
                <th width="47%" align="left">Descrição</th>
                <th width="47%" align="left">Observação</th>
                <th width="7%" align="center">CP</th>
                <th width="7%" align="center">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($ficorcamentarias as $ficorcamentaria)
                <tr>
                    <td align="left">{{ $ficorcamentaria->dotacao->dotacao ?? '' }}</td>
                    <td align="left">{{ $ficorcamentaria->data }}</td>
                    <td align="left">{{ $ficorcamentaria->descricao }}</td>
                    <td align="left">{{ $ficorcamentaria->observacao }}</td>
                    <td>{{ $ficorcamentaria->ficorcamentaria_id }}</td>
                    @if($ficorcamentaria->debito != 0.00)
                        <td>{{ number_format($ficorcamentaria->debito_raw, 2, ',', '.') }}</td>
                    @else
                        <td>&nbsp;</td>
                    @endif
                    @if($ficorcamentaria->credito != 0.00)
                        <td>{{ number_format($ficorcamentaria->credito_raw, 2, ',', '.') }}</td>
                    @else
                        <td align="right">&nbsp;</td>
                    @endif
                    <td>{{ $ficorcamentaria->saldo }}</td>
                    <td align="center"><a class="btn btn-secondary" href="/ficorcamentarias/{{$ficorcamentaria->id}}">Ver</a></td>
                    @can('Administrador')
                    <td align="center"><a class="btn btn-warning" href="/ficorcamentarias/{{$ficorcamentaria->id}}/edit">Editar</a></td>
                    <td align="center">
                        <form method="post" role="form" action="{{ route('ficorcamentarias.destroy', $ficorcamentaria) }}" >
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Ficha Orçamentária?');">Excluir</button>
                        </form>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<br>
@include('lancamentos.partials.saldo')
@endsection
@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.dotacoes_select').select2();
        });
    </script>
@stop
