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

  <h1><center>[ Grupo {{ $grupo }} ]</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="60%">Dotação</th>
        <th width="20%">Item</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach ($saldo_dotacoes as $saldo_dotacao)
      <tbody>
          <tr>
            <td align="left">{{ $saldo_dotacao->dotacao }}</td>
            <td align="right">{{ $saldo_dotacao->item }}</td>
            <td align="right">{{ $saldo_dotacao->total_credito - $saldo_dotacao->total_debito }}</td>

          </tr>
      </tbody>
    @endforeach
  </table>
  
@endsection
