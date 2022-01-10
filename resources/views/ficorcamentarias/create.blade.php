@extends('master')

@section('title')
  Adicionar Ficha Orçamentária
@endsection

@section('content')
<div class="card p-3">
<h2><strong>Fichas Orçamentárias - Inclusão</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <!--form method="post" action="{{ url('/ficorcamentarias/cpfo') }}"-->
    <form method="post" action="/ficorcamentarias/cpfo">
      @csrf
      @include('ficorcamentarias.form')
    </form>
  </div>
</div>
@endsection

@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.dotacoes_select').select2();
        });
    </script>

@stop
