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
        <th width="8%">Crédtio</th>
        <th width="8%">Saldo</th>
        <th width="30%">Observação</th>

      </tr>
    </thead>
    @foreach ($ficha_orcamentaria as $ficha_orcamentaria_valor)
      <tbody>
          <tr>
            <td align="center">{{ $ficha_orcamentaria_valor->data }}</td>
            <td align="right">{{ $ficha_orcamentaria_valor->empenho }}</td>
            <td align="left">{{ $ficha_orcamentaria_valor->descricao }}</td>
            <td align="right">{{ number_format($ficha_orcamentaria_valor->debito, 2, ',', '.') }}</td>
            <td align="right">{{ number_format($ficha_orcamentaria_valor->credito, 2, ',', '.') }}</td>
            <td align="right">{{ $ficha_orcamentaria_valor->saldo }}</td>
            <td align="left">{{ $ficha_orcamentaria_valor->observacao }}</td>

          </tr>
      </tbody>
    @endforeach
  </table>
  
@endsection
