@extends('master')
@section('title')
    Lançamentos
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Lançamentos</strong></h2>
    @include('partials.mostra_ano')
</div>
<br>
<div class="form-row">
    <div class="form-group col-md-10">
        <form method="get" action="/lancamentos/search">
            @csrf
            <div class="row">
                <div class="col-sm input-group">
                    <select class="contas_select form-control" name="conta_id" tabindex="1" onchange="this.form.submit()">
                        <option value=" ">[ Busca por Conta ]</option>
                        @foreach($lista_contas_ativas as $lista_conta_ativa)
                            @if(old('conta_id') == '')
                                <option value="{{ $lista_conta_ativa->id }}"
                                {{ ( $lista_conta_ativa->id == request()->conta_id ) ? 'selected' : '' }}>
                                {{ $lista_conta_ativa->nome }} ({{ $lista_conta_ativa->descricao}})
                                </option>
                                @else
                                <option value="{{ $lista_conta_ativa->id }}">
                                {{ $lista_conta_ativa->nome }} ({{ $lista_conta_ativa->descricao}})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    &nbsp;E/OU&nbsp;
                    <input size="100%" type="text" class="form-control" name="grupo" value="{{ request()->busca_grupo }}" placeholder="[ Busca por Grupo ]">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-success"><strong>Buscar</strong></button>
                        <a class="btn btn-danger" href="/lancamentos" title="Limpar a Busca"><strong>X</strong></a>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="form-group col-md-2" align="right">
        <a href="{{ route('lancamentos.create') }}" class="btn btn-success"><strong>Adicionar Lançamento</strong></a>
    </div>

</div>
<div class="table-responsive">
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th width="5%" align="left">Data</th>
                <th width="34%" align="left">Descrição</th>
                <th width="34%" align="left">Observação</th>
                <th width="7%" align="left">Grupo</th>
                <th width="7%" align="left">CP</th>
                <th width="7%" align="left">REC</th>
                <th width="7%" align="left">Débito</th>
                <th width="7%" align="center">Crédito</th>
                <th width="7%" align="center">Saldo</th>
                @can('Administrador')
                    <th width="10%" align="center" colspan="3">&nbsp;</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach($lancamentos as $lancamento)
                <tr>
                    <td align="left">{{$lancamento->id }} {{ $lancamento->data }}</td>
                    <td align="left">{{ $lancamento->descricao }}</td>
                    <td align="left">{{ $lancamento->observacao }}</td>
                    <td align="left">{{ $lancamento->grupo  }}</td>
                    <td align="left">{{ $lancamento->ficorcamentaria_id  }}</td>
                    <td>{{ $lancamento->receita }}</td>
                    <td>{{ number_format($lancamento->valor_debito, 2, ',', '.') }}</td>
                    <td>{{ number_format($lancamento->valor_credito, 2, ',', '.') }}</td>
                    <td>{{ number_format($lancamento->saldo, 2, ',', '.') }}</td>
                    <td align="center"><a class="btn btn-secondary" href="/lancamentos/{{$lancamento->id}}">Ver</a></td>
                    @can('Administrador')
                        <td align="center"><a class="btn btn-warning" href="/lancamentos/{{$lancamento->id}}/edit">Editar</a></td>
                        <td align="center">
                          <form method="post" role="form" action="{{ route('lancamentos.destroy', $lancamento->id) }}" >
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir o Lançamento?');">Excluir</button>
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
            $('.contas_select').select2();
        });
    </script>
@stop
