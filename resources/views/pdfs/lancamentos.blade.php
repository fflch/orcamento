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
        <th width="8%">Crédtio</th>
        <th width="8%">Saldo</th>
        <th width="30%">Observação</th>

      </tr>
    </thead>
    @foreach ($lancamentos as $lancamento)
      <tbody>
          <tr>
            <td align="center">{{ $lancamento->data }}</td>
            <td align="right">{{ $lancamento->empenho }}</td>
            <td align="left">{{ $lancamento->descricao }}</td>
            <td align="right">{{ number_format($lancamento->debito_raw, 2, ',', '.') }}</td>
            <td align="right">{{ number_format($lancamento->credito_raw, 2, ',', '.') }}</td>
            <td align="right">{{ $lancamento->saldo }}</td>
            <td align="left">{{ $lancamento->observacao }}</td>

          </tr>
      </tbody>
    @endforeach
  </table>
  
@endsection
