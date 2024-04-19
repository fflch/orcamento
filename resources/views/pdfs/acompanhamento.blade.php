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
  @foreach ($saldo_inicial as $key => $acompanhamento)
  <h1><center>Acompanhamento do grupo {{ request()->grupo }} - {{ $acompanhamento->descricaogrupo }} até o dia {{ request()->data }}</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
      <tbody>
          <tr>
            <td style="border: 1px solid black">Saldo Inicial</td>
            <td style="border: 1px solid black">{{ number_format($acompanhamento->SDOINICIAL, 2, ',', '.') }}</td>
          </tr>
      </tbody>
    @endforeach
    @foreach ($suplementacoes as $key => $acompanhamento)
      <tbody>
          <tr>
            <td style="border: 1px solid black">{{ $acompanhamento->descricao }}</td>
            <td style="border: 1px solid black">{{ number_format($acompanhamento->TOTALCREDITO, 2, ',', '.') }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
  <h3><center>SITUAÇÃO ORÇAMENTÁRIA - GASTOS EFETIVOS</center></h3>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach ($table as $key => $acompanhamento)
      <tbody>
          <tr>
            <td align="left" style="border: 1px solid black">{{ $acompanhamento['nome_conta'] }}</td>
            <td align="right" style="border: 1px solid black">{{ number_format($acompanhamento['saldo'],2) }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
  @if(request()->receita_acompanhamento == null && request()->grupo == (int)80)
    <h1><center>Básica {{ request()->grupo }} - Previsão da Administração até o dia {{ request()->data }}</center></h1>
    <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach($orcamento as $key => $acompanhamento)
      <tbody>
          <tr>
            <td style="border: 1px solid black">{{ $acompanhamento->nome }}</td>
            <td style="border: 1px solid black">{{ number_format($acompanhamento->TOTALCREDITO - $acompanhamento->TOTALDEBITO, 2, ',', '.') }}</td>
          </tr>
      </tbody>
    @endforeach
  @elseif(request()->receita_acompanhamento != null && request()->grupo == (int)80)
    <h1><center>Renda Industrial {{ request()->grupo }} - Administração até o dia {{ request()->data }}</center></h1>
    <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Saldo</th>
      </tr>
    </thead>
    @foreach($renda_industrial as $key => $acompanhamento)
      <tbody>
          <tr>
            <td style="border: 1px solid black">{{ $acompanhamento->nome }}</td>
            <td style="border: 1px solid black">{{ number_format($acompanhamento->TOTALCREDITO, 2, ',', '.') }}</td>
          </tr>
      </tbody>
    @endforeach
  @endif
@endsection
