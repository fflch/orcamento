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
  <h1><center>[ Aqui vai o tipo de conta e a conta ]</center></h1>
  <table width="100%" border="0px">
    <thead>
      <tr>
        <th width="80%">Descrição</th>
        <th width="20%">Valor</th>
      </tr>
    </thead>
    @foreach ($acompanhamento as $acompanhamento_valor)
      <tbody>
          <tr>
            <td align="left">{{ $acompanhamento_valor->nome }}</td>
            <td align="right">{{ $acompanhamento_valor->ativo }}</td>
          </tr>
      </tbody>
    @endforeach
  </table>
@endsection
