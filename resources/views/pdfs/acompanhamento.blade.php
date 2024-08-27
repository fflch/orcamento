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
  <br><h3><center>Acompanhamento do grupo {{ request()->grupo }} - {{ $saldo_inicial->descricaogrupo }} até o dia {{ request()->data }}</center></h3>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td align="left" style="border: 1px solid black">Saldo Inicial</td>
          <td align="right" style="border: 1px solid black">{{ number_format($saldo_inicial->saldoinicial, 2, ',', '.') }}</td>
        </tr>
      @foreach ($suplementacoes as $suplementa)
        <tr>
          <td align="left" style="border: 1px solid black">{{ $suplementa->descricao }}</td>
          <td align="right" style="border: 1px solid black">{{ number_format($suplementa->total, 2, ',', '.') }}</td>
        </tr>
      @endforeach
        <tr>
            <td align="left" style="border: 1px solid black"><b>SUBTOTAL</b></td>
            <td align="right" style="border: 1px solid black"><b>{{ number_format($total_suplementacoes, 2, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td align="left" style="border: 1px solid black"><b>TOTAL</b></td>
            <td align="right" style="border: 1px solid black"><b>{{ number_format($saldo_inicial->saldoinicial + $total_suplementacoes, 2, ',', '.') }}</b></td>
        </tr>
    </tbody>
  </table>

  <h3><center>SITUAÇÃO ORÇAMENTÁRIA - GASTOS EFETIVOS</center></h3>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach ($gastos as $gasto)
      <tr>
        <td align="left" style="border: 1px solid black">{{ $gasto->nome }}</td>
        <td align="right" style="border: 1px solid black">{{ number_format($gasto->total,2) }}</td>
      </tr>
    @endforeach
    <tr>
      <td align="left" style="border: 1px solid black"><b>SUBTOTAL</b></td>
      <td align="right" style="border: 1px solid black"><b>{{ number_format($total_gastos, 2, ',', '.') }}</b></td>
    </tr>
    <tr>
      <td align="left" style="border: 1px solid black"><b>DISPONÍVEL</b></td>
      <td align="right" style="border: 1px solid black"><b>{{ number_format(($saldo_inicial->saldoinicial + $total_suplementacoes) - $total_gastos, 2, ',', '.') }}</b></td>
    </tr>
    </tbody>
  </table>

  @if(request()->receita_acompanhamento == null && request()->grupo == (int)80)
    <div style="page-break-before: always;"></div>
    <br />
    <h3><center>Básica {{ request()->grupo }} - Previsão da Administração até o dia {{ request()->data }}</center></h3>
    <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td align="left" style="border: 1px solid black"><b>SALDO ORÇAMENTÁRIO</b></td>
          <td align="right" style="border: 1px solid black"><b>{{ number_format(($saldo_inicial->saldoinicial + $total_suplementacoes) - $total_gastos, 2, ',', '.') }}</b></td>
        </tr>
    @foreach($naoverbaprevisoes as $naoverbaprevisao)
        <tr>
          <td align="left" style="border: 1px solid black">{{ $naoverbaprevisao->nome }}</td>
          <td align="right" style="border: 1px solid black">{{ number_format($naoverbaprevisao->total, 2, ',', '.') }}</td>
        </tr>
    @endforeach
        <tr>
            <td align="left" style="border: 1px solid black"><b>SUBTOTAL</b></td>
            <td align="right" style="border: 1px solid black"><b>{{ number_format($total_naoverbaprevisoes, 2, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td align="left" style="border: 1px solid black"><b>TOTAL</b></td>
            <td align="right" style="border: 1px solid black"><b>{{ number_format(($saldo_inicial->saldoinicial + $total_suplementacoes) - $total_gastos - $total_naoverbaprevisoes, 2, ',', '.') }}</b></td>
        </tr>
    </tbody>

  @elseif(request()->receita_acompanhamento != null && request()->grupo == (int)80)
    <div style="page-break-before: always;"></div>
    <br />
    <h3><center>Renda Industrial {{ request()->grupo }} - Administração até o dia {{ request()->data }}</center></h3>
    <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td align="left" style="border: 1px solid black"><b>SALDO ORÇAMENTÁRIO</b></td>
        <td align="right" style="border: 1px solid black"><b>{{ number_format(($saldo_inicial->saldoinicial + $total_suplementacoes) - $total_gastos, 2, ',', '.') }}</b></td>
      </tr>
      @foreach($renda_industriais as $renda_industrial)
        <tr>
          <td align="left" style="border: 1px solid black">{{ $renda_industrial->nome }}</td>
          <td align="right" style="border: 1px solid black">{{ number_format($renda_industrial->total, 2, ',', '.') }}</td>
        </tr>
      @endforeach
      <tr>
        <td align="left" style="border: 1px solid black"><b>SUBTOTAL</b></td>
        <td align="right" style="border: 1px solid black"><b>{{ number_format($total_renda_industrial, 2, ',', '.') }}</b></td>
      </tr>
        <tr>
          <td align="left" style="border: 1px solid black"><b>TOTAL</b></td>
          <td align="right" style="border: 1px solid black"><b>{{ number_format($saldo_inicial->saldoinicial + $total_suplementacoes - $total_gastos - $total_renda_industrial, 2, ',', '.') }}</b></td>
    </tbody>
  </table>
  @endif
@endsection
