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
  <h1><center>Despesas Miúdas</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="10%">Data</th>
        <th width="35%">Descrição</th>
        <th width="10%">Crédito</th>
        <th width="10%">Débito</th>
      </tr>
    </thead>
    @foreach ($despesas_miudas as $despesa_miuda)
      <tbody>
          <tr>
            <td align="right">{{ $despesa_miuda->data }}</td>
            <td align="right">{{ $despesa_miuda->descricao }}</td>
            <td align="right">{{ $despesa_miuda->credito }}</td>
            <td align="right">{{ $despesa_miuda->debito }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
@endsection
