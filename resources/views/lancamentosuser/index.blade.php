@extends('master')
@section('title')
    Contas - {{ $user->name }}
@stop
@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div class="card p-3">
    <h2><strong>Contas vinculadas ao usuário: {{ $user->name }}</strong></h2>
<br>
<form method="GET" action="/lancamentos_usuario">
@csrf
    <div class="form-group col-md-9">
        <label for="conta">Escolha uma Conta: </label>
        <select class="contas_select form-control" name="conta_id" tabindex="1">
            <option value="">&nbsp;</option>
                @foreach($contas as $conta)
                @if(old('conta_id') == '')
                    <option value="{{ $conta->id }}"
                        {{ ( $conta->id == request()->conta_id ) ? 'selected' : '' }}>
                        {{ $conta->nome }} - {{ $conta->tipoconta->descricao }}
                    </option>
                @else
                    <option value="{{ $conta->id }}"
                        {{ ( $conta->id == old('conta_id') ) ? 'selected' : '' }}>
                        {{ $conta->nome }} - {{ $conta->tipoconta->descricao }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
        <div class="form-group col-md-4">
            @if(request()->data_inicial)
            <input autocomplete="off" type="text" class="form-control datepicker data" name="data_inicial" value="{{ request()->data_inicial }}">
            @else
            <input autocomplete="off" type="text" class="form-control datepicker data" name="data_inicial" value="{{ old('data_inicial') }}">
            @endif
        </div>
        <div class="form-group col-md-4">
            @if(request()->data_inicial)
            <input autocomplete="off" type="text" class="form-control datepicker data" name="data_final" value="{{ request()->data_final }}">
            @else
            <input autocomplete="off" type="text" class="form-control datepicker data" name="data_final" value="{{ old('data_final') }}">
            @endif
        </div>
        <div class="form-group col-md-4">
        <button type="submit" class="btn btn-success">Buscar</button>
        </div>
    </div>
</form>
    @isset($lancamentos)
    <br>
    <div class="form-group">
        <div class="w-50 d-inline-block">
          <h2><strong>Lançamentos</strong></h2>
        </div>
        @if($lancamentos->count() > 0)
        <div class="w-25 float-right">
          <a href="/lancamentos_usuario_pdf/?conta_id={{ request()->get('conta_id') }}&data_inicial={{ request()->get('data_inicial') }}&data_final={{ request()->get('data_final') }}" class="btn btn-success">
            <i class="fa fa-file" aria-hidden="true"></i>
                Gerar PDF
          </a>
        </div>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-striped" border="0">
            <thead>
                <tr>
                    <th width="10%" align="left">Data</th>
                    <th width="34%" align="left">Descrição</th>
                    <th width="34%" align="left">Observação</th>
                    <th width="7%" align="left">Débito</th>
                    <th width="7%" align="center">Crédito</th>
                    <th width="7%" align="center">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lancamentos as $lancamento)
                        <tr>
                                <td align="left">{{ $lancamento->data }}</td>
                                <td align="left">{{ $lancamento->descricao }}</td>
                                <td align="left">{{ $lancamento->observacao }}</td>
                                    <td>{{ number_format($lancamento->debito, 2, ',', '.') }}</td>
                                <td>{{ number_format($lancamento->credito, 2, ',', '.') }}</td>
                                <td>{{ number_format($lancamento->saldo, 2, ',', '.') }}</td>
                        </tr>
                @empty
                    <tr> <td colspan="6" align="center"> Não há lançamentos cadastrados nesse período. </td> </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <br>
    <h5><strong>Saldo total da conta:</strong></h5>
    <br>
    @include('lancamentos.partials.saldo')
    @endisset
@endsection
