@extends('master')

@section('title')
    Relatórios
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div class="card p-3">
    <h2><strong>Relatórios</strong></h2>
</div>
<br> 
<div class="form-row">
    @include('relatorios.indexbalancete')
    @include('relatorios.indexacompanhamento')
    @include('relatorios.indexsaldocontas')
    @include('relatorios.indexsaldodotacoes')
</div>
<div class="form-row">
    @include('relatorios.indexlancamentos')
    @include('relatorios.indexfichaorcamentaria')
</div>
<div class="form-row">
    @include('relatorios.indexdespesas')
    <div class="form-group col-md-3 p-3"></div>
    <div class="form-group col-md-3 p-3"></div>
    @include('relatorios.indexdespesasmiudas')
</div>
@stop
