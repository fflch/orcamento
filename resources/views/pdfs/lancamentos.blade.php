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
            <td align="right" style="border: 1px solid black">{{ $lancamento->saldo }}</td>
            <td align="left" style="border: 1px solid black">{{ $lancamento->observacao }}</td>
          </tr>
      </tbody>
      @endif
      @endforeach
    @endforeach
  </table>
@endsection
