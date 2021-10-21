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

  <h1><center>Balancete até o dia {{ $periodo }}</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="61%" align="left">Departamentos, Centros e SBD</th>
        <th width="13%">Orçamento</th>
        <th width="13%">Renda Industrial</th>
        <th width="13%">Total Geral</th>
      </tr>
    </thead>
    @foreach ($balancete as $valor)
      <tbody>
          <tr>
            <td align="left"> {{ $valor->descricao }}</td>
            <td align="right"> {{ $valor->debito }}</td>
            <td align="right">R$ {{ $valor->credito }}</td>
            <td align="right"> {{ $valor->observacao }} de {{ $valor->grupo }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
  <table width="100%" border="0px" style="background-color:#A2A2A2;">
    <tbody>
        <tr>
          <td width="61%" align="right">Totais Gerais</td>
          <td width="13%" align="right">{{ $valor->debito }}</td>
          <td width="13%" align="right">{{ $valor->credito }}</td>
          <td width="13%" align="right">{{ $valor->debito }} - {{ $valor->credito }}</td>
        </tr>
     <tbody>
  </table>

@endsection
