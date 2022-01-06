@extends('master')

@section('title')
    Relatórios
@stop

@section('styles')
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script
      src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js">
    </script>
@endsection

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
@endsection

@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.tipocontas_select').select2();
        });

        $(document).ready(function() {
            $('.areas_select').select2();
        });
    </script>

@stop
