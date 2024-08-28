@extends('laravel-fflch-pdf::main')
@section('content')
  <style>
    #valor {
      text-align: right;
    }
    td {
      padding-right: 5px;
      padding-left: 5px;
      padding-top: 5px;
      padding-bottom: 5px;
    }
    thead {
      background-color: #0F1C78;
      color: #FFFFFF;
    }
    .bold-text {
      font-weight: bold;
    }
    .total-row {
      background-color: #A2A2A2;
    }
  </style>
  <br><h3><center>[ {{ $descricao_tipoconta }} ]</center></h3>

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
            <td align="left" style="border: 1px solid black">{{ $saldo_conta->nome }}</td>
            <td align="right" style="border: 1px solid black">{{ number_format($saldo_conta->total, 2, ',', '.') }}</td>
          </tr>
    @endforeach
      <tr class="total-row">
        <td align="left" style="border: 1px solid black; font-weight: bold;">TOTAL</td>
        <td align="right" style="border: 1px solid black; font-weight: bold;">{{ number_format($total_saldo_contas, 2, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
@endsection
