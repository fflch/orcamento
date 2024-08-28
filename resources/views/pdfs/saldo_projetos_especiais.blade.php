@extends('laravel-fflch-pdf::main')
@section('content')
  <style>
    #valor {
      text-align: right;
    }
    td {
      padding-right: 5px;
      padding-left: 5px;
      padding-top: 5px;
      padding-bottom: 5px;
    }
    thead {
      background-color: #0F1C78;
      color: #FFFFFF;
    }
  </style>

  <h1><center>Orçamento</center></h1>
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
            <td align="right" style="border: 1px solid black">{{ number_format($saldo_conta->total, 2, ',', '.') }}</td>
          </tr>
    @endforeach
      <tr style="background-color:#A2A2A2;">
        <td align="left" style="border: 1px solid black; font-weight: bold;">TOTAL</td>
        <td align="right" style="border: 1px solid black; font-weight: bold;">{{ number_format($total_saldo_contas_orcamento, 2, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>

  <h1><center>Renda Industrial</center></h1>
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
            <td align="right" style="border: 1px solid black">{{ number_format($saldo_conta->total, 2, ',', '.') }}</td>
          </tr>
    @endforeach
      <tr style="background-color:#A2A2A2;">
        <td align="left" style="border: 1px solid black; font-weight: bold;">TOTAL</td>
        <td align="right" style="border: 1px solid black; font-weight: bold;">{{ number_format($total_saldo_contas_renda_industrial, 2, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
@endsection
