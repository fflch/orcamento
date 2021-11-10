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

  <h1><center>[ {{ $descricao_tipoconta }} ]</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Conta</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach ($saldo_contas as $saldo_conta)
      <tbody>
          <tr>
            <td align="left">{{ $saldo_conta->nome }}</td>
            <td align="right">{{ $saldo_conta->total_credito - $saldo_conta->total_debito }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
  
@endsection
