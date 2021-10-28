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

  <h1><center>[ Aqui vai a dotação ]</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="15%">Área</th>
        <th width="30%">Seção</th>
        <th width="10%">Data</th>
        <th width="35%">Descrição</th>
        <th width="10%">Valor</th>
      </tr>
    </thead>
    @foreach ($despesas_miudas as $despesa_miuda)
      <tbody>
          <tr>
            <td align="left">{{ $despesa_miuda->id }}</td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
          </tr>
      </tbody>
    @endforeach
  </table>
  
@endsection
