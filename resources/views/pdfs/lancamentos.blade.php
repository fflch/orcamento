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
  <br><h3><center>[ {{ $nome_conta }} ]</center></h3>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="8%">Data</th>
        <th width="8%">Empenho</th>
        <th width="30%">Descrição</th>
        <th width="8%">Débito</th>
        <th width="8%">Crédito</th>
        <th width="8%">Saldo</th>
        <th width="30%">Observação</th>
      </tr>
    </thead>
    @foreach ($lancamentos as $lancamento)
        <tbody>
            <tr>
              <td align="center" style="border: 1px solid black">{{ $lancamento->data }}</td>
              <td align="right" style="border: 1px solid black">{{ $lancamento->empenho }}</td>
              <td align="left" style="border: 1px solid black">{{ $lancamento->descricao }}</td>
              <td align="right" style="border: 1px solid black">{{ number_format($lancamento->valor_debito, 2, ',', '.') }}</td>
              <td align="right" style="border: 1px solid black">{{ number_format($lancamento->valor_credito, 2, ',', '.') }}</td>
              <td align="left" style="border: 1px solid black">{{ number_format($lancamento->saldo, 2, ',', '.') }}</td>
              <td align="left" style="border: 1px solid black">{{ $lancamento->observacao }}</td>
            </tr>
        </tbody>
    @endforeach
  </table>
  <table width="100%" border="0px" style="background-color:#A2A2A2;">
    <tbody>
        <tr>
          <td width="10%" align="center" style="border: 1px solid black"><strong>Totais Gerais</strong></td>
          <td width="30%" align="center" style="border: 1px solid black"><strong>Débitos: {{ number_format($total_debito, 2, ',', '.') }}</td>
          <td width="30%" align="center" style="border: 1px solid black"><strong>Créditos: {{ number_format($total_credito, 2, ',', '.') }}</td>
          <td width="30%" align="center" style="border: 1px solid black"><strong>Saldo total: {{ number_format($total_credito - $total_debito, 2, ',', '.') }}</td>
        </tr>
    </tbody>
  </table>
@endsection
