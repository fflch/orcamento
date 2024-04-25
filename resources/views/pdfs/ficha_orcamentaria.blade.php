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
  <h1><center>[ {{ $dotacao }} ]</center></h1>
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
    {{ $total_debito = 0 }}
    {{ $total_credito = 0 }}
    @foreach ($ficha_orcamentaria as $ficha_orcamentaria_valor)
      <tbody>
          <tr>
            <td align="center" style="border: 1px solid black">{{ $ficha_orcamentaria_valor->data }}</td>
            <td align="right" style="border: 1px solid black">{{ $ficha_orcamentaria_valor->empenho }}</td>
            <td align="left" style="border: 1px solid black">{{ $ficha_orcamentaria_valor->descricao }}</td>
            @if($ficha_orcamentaria_valor->debito != 0.00)
              <td align="right" style="border: 1px solid black">{{ number_format($ficha_orcamentaria_valor->debito_raw, 2, ',', '.') }}</td>
            @else
              <td align="right" style="border: 1px solid black">&nbsp;</td>
            @endif
            @if($ficha_orcamentaria_valor->credito != 0.00)
              <td align="right" style="border: 1px solid black">{{ number_format($ficha_orcamentaria_valor->credito_raw, 2, ',', '.') }}</td>
            @else
              <td align="right" style="border: 1px solid black">&nbsp;</td>
            @endif
            <td align="left" style="border: 1px solid black">{{ number_format($ficha_orcamentaria_valor->saldo_valor, 2, ',', '.') }}</td>
            <td align="left" style="border: 1px solid black">{{ $ficha_orcamentaria_valor->observacao }}</td>
          </tr>
      </tbody>
      {{ $total_debito += $ficha_orcamentaria_valor->debito_raw }}
      {{ $total_credito += $ficha_orcamentaria_valor->credito_raw }}
    @endforeach
  </table>
  <table width="100%" border="0px" style="background-color:#A2A2A2;">
    <tbody>
        <tr>
          <td width="61%" align="center" style="border: 1px solid black"><strong>Totais Gerais</strong></td>
          <td width="13%" align="center" style="border: 1px solid black"><strong>Débitos: {{ number_format($total_debito, 2, ',', '.') }}</td>
          <td width="13%" align="center" style="border: 1px solid black"><strong>Créditos: {{ number_format($total_credito, 2, ',', '.') }}</td>
          <td width="13%" align="center" style="border: 1px solid black"><strong>Saldo total: {{ number_format($total_credito - $total_debito, 2, ',', '.') }}</td>
        </tr>
    </tbody>
  </table>
@endsection
