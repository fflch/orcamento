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
      background-color: #dfdacd;
    }
  </style>

  <h3>Balancete até o dia </h3>
  <br>
  <h3>Parcelas de {{ request()->start_date }} a {{ request()->end_date }}</h3>
  <table width="100%" border="1px">
    <thead>
      <tr>
        <th>Departamentos, Centros e SBD</th>
        <th>Orçamento</th>
        <th>Renda Industrial</th>
        <th>Total Geral</th>
      </tr>
    </thead>
    @foreach ($balancete as $valor)
      <tbody>
          <tr>
            <td> {{ $valor->descricao }}</td>
            <td> {{ $valor->debito }}</td>
            <td>R$ {{ $valor->credito }}</td>
            <td> {{ $valor->observacao }} de {{ $valor->grupo }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
  <br>
  <h3>Totais</h3>
  <table width="100%" border="1px">
    <thead>
      <tr>
        <th>Total vendido</th>
        <th>Total vendido</th>
        <th>Comissão FAC</th>
        <th>Total a pagar</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td>{{ $valor->debito }}</td>
          <td>{{ $valor->credito }}</td>
          <td>{{ $valor->debito }} - {{ $valor->credito }}</td>
        </tr>
     <tbody>
  </table>

@endsection
