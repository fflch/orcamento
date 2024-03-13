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
    {{ $total_geral_debito = 0 }}
    {{ $total_geral_credito = 0 }}
    @foreach ($balanceteO as $valor)
      <tbody>
          <tr>
            <td align="left" style="border: 1px solid black"> {{ $valor->nome }}</td>
            <td align="right" style="border: 1px solid black"> {{ number_format($valor->total_credito - $valor->total_debito, 2, ',', '.') }}</td>
            <td align="right" style="border: 1px solid black"> </td>
            <td align="right" style="border: 1px solid black"> {{ number_format($valor->total_credito - $valor->total_debito, 2, ',', '.') }} </td>
            {{ $total_geral_debito += $valor->total_debito }}
            {{ $total_geral_credito += $valor->total_credito }}
          </tr>
      </tbody>
    @endforeach
  </table>
  <table width="100%" border="0px" style="background-color:#A2A2A2;">
    <tbody>
        <tr>
          <td width="61%" align="right" style="border: 1px solid black">Totais Gerais</td>
          <td width="13%" align="right" style="border: 1px solid black">{{ number_format($total_geral_debito, 2, ',', '.') }}</td>
          <td width="13%" align="right" style="border: 1px solid black">{{ number_format($total_geral_credito, 2, ',', '.') }}</td>
          <td width="13%" align="right" style="border: 1px solid black">{{ number_format($total_geral_credito - $total_geral_debito, 2, ',', '.') }}</td>
        </tr>
     <tbody>
  </table>
@endsection
