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

  @php $soma_saldo = 0; @endphp

  <br><h3><center>[ Grupo {{ $grupo }} ]</center></h3>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="60%">Dotação</th>
        <th width="20%">Item</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($saldo_dotacoes as $saldo_dotacao)
    @php $soma_saldo =$soma_saldo +$saldo_dotacao->total_credito - $saldo_dotacao->total_debito ;  @endphp
          <tr>
            <td align="left" style="border: 1px solid black">{{ $saldo_dotacao->dotacao }}</td>
            <td align="right" style="border: 1px solid black">{{ $saldo_dotacao->item }}</td>
            <td align="right" style="border: 1px solid black">{{ number_format($saldo_dotacao->total_credito - $saldo_dotacao->total_debito, 2, ',', '.') }}</td>
          </tr>
    @endforeach
    <tr>
          <td align="left" style="border: 1px solid black" colspan='2'><b>TOTAL</b></td>
          <td align="right" style="border: 1px solid black"><b>{{ number_format($soma_saldo, 2, ',', '.') }}</b></td>
        </tr>
    </tbody>
  </table>
  
@endsection
