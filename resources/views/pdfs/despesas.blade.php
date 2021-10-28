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
        <th width="20%">Seção/Serviço</th>
        <th width="5%">JAN</th>
        <th width="5%">FEV</th>
        <th width="5%">MAR</th>
        <th width="5%">ABR</th>
        <th width="5%">MAI</th>
        <th width="5%">JUN</th>
        <th width="5%">JUL</th>
        <th width="5%">AGO</th>
        <th width="5%">SET</th>
        <th width="5%">OUT</th>
        <th width="5%">NOV</th>
        <th width="5%">DEZ</th>
        <th width="5%">SUPLE</th>
        <th width="5%">TOTAL</th>
        <th width="5%">DISTR</th>
        <th width="5%">SALDO</th>


      </tr>
    </thead>
    @foreach ($despesas as $despesa)
      <tbody>
          <tr>
            <td align="left">{{ $despesa->id }}</td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
            <td align="right"></td>
          </tr>
      </tbody>
    @endforeach
  </table>
  
@endsection
