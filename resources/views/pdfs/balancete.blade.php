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
  <h1><center>[ Balancete até o dia {{ $periodo }} ]</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="61%" align="left">Departamentos, Centros e SBD</th>
        <th width="13%">Orçamento</th>
        <th width="13%">Renda Industrial</th>
        <th width="13%">Total Geral</th>
      </tr>
    </thead>
    {{ $total_orcamento = 0 }}
    {{ $total_renda = 0 }}
    @foreach ($balancete as $key => $saldo)
      <tbody>
          <tr>
            <td align="left" style="border: 1px solid black"> {{ $key }}</td>
            <td align="right" style="border: 1px solid black"> {{ number_format($saldo['saldo_orcamento'], 2) }} </td>
            <td align="right" style="border: 1px solid black"> {{ number_format($saldo['saldo_renda'], 2) }} </td>
            <td align="right" style="border: 1px solid black"> {{ number_format($saldo['saldo_orcamento'] +  $saldo['saldo_renda'], 2) }}</td>
          </tr>
      {{ $total_orcamento += $saldo['saldo_orcamento'] }}
      {{ $total_renda += $saldo['saldo_renda'] }}
    @endforeach
          <tr style="background-color:#A2A2A2;">
            <td width="61%" align="right" style="border: 1px solid black">Totais Gerais</td>
            <td width="13%" align="right" style="border: 1px solid black">{{ number_format($total_orcamento, 2, ',', '.') }}</td>
            <td width="13%" align="right" style="border: 1px solid black">{{ number_format($total_renda, 2, ',', '.') }}</td>
            <td width="13%" align="right" style="border: 1px solid black">{{ number_format($total_orcamento + $total_renda, 2, ',', '.') }}</td>
          </tr>
     <tbody>
  </table>
@endsection
