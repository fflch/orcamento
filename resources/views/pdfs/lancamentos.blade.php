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
  <h1><center>[ {{ $nome_conta }} ]</center></h1>
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
    @foreach ($lancamentos as $lancamento)
      @foreach($lancamento->contas as $conta)
        @if($conta->id == $conta_id)
        <tbody>
            <tr>
              <td align="center" style="border: 1px solid black">{{ $lancamento->data }}</td>
              <td align="right" style="border: 1px solid black">{{ $lancamento->empenho }}</td>
              <td align="left" style="border: 1px solid black">{{ $lancamento->descricao }}</td>
              @if($lancamento->debito != 0.00)
                  <td align="right" style="border: 1px solid black">{{ number_format((float)($lancamento->debito_raw * $conta->pivot->percentual/100),2, ',', '.') }}</td>
              @else
                  <td align="right" style="border: 1px solid black">&nbsp;</td>
              @endif
              @if($lancamento->credito != 0.00)
              <td align="right" style="border: 1px solid black">{{ number_format((float)($lancamento->credito_raw * $conta->pivot->percentual/100),2, ',', '.') }}</td>
              @else
                  <td align="right" style="border: 1px solid black">&nbsp;</td>
              @endif
              <td align="left" style="border: 1px solid black">{{ number_format($lancamento->saldo_valor, 2, ',', '.') }}</td>
              <td align="left" style="border: 1px solid black">{{ $lancamento->observacao }}</td>
            </tr>
        </tbody>
        {{ $total_debito += (float)($lancamento->debito_raw * $conta->pivot->percentual/100) }}
        {{ $total_credito += (float)($lancamento->credito_raw * $conta->pivot->percentual/100) }}
        @endif
      @endforeach
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
