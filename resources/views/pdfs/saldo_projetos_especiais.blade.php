@extends('laravel-fflch-pdf::main')
@section('content')
  <style>
    #valor {
      text-align: right;
    }
    td {
      padding-right: 5 px;
      padding-left: 5 px;
      padding-top: 5 px;
      padding-bottom: 5 px;
    }
    thead {
      background-color: #0F1C78;
      color: #FFFFFF;
      padding-right: 5 px;
      padding-left: 5 px;
      padding-top: 5 px;
      padding-bottom: 5 px;
    }
  </style>

  <h1>Orçamento</h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Conta</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach ($saldo_contas_orcamento as $saldo_conta)
      <tbody>
          <tr>
            <td align="left" style="border: 1px solid black">{{ $saldo_conta->nome }}</td>
            <td align="right" style="border: 1px solid black">{{ number_format($saldo_conta->total_credito - $saldo_conta->total_debito, 2, ',', '.') }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>

  <h1>Renda Industrial</h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Conta</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach ($saldo_contas_renda_industrial as $saldo_conta)
      <tbody>
          <tr>
            <td align="left" style="border: 1px solid black">{{ $saldo_conta->nome }}</td>
            <td align="right" style="border: 1px solid black">{{ number_format($saldo_conta->total_credito - $saldo_conta->total_debito, 2, ',', '.') }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>

@endsection
