@extends('master')

@section('title')
  Adicionar Lançamento
@endsection

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
  <div class="border rounded bg-light">
    <h3 class="ml-2 mt-2">Adicionar Lançamento</h3>
    <div class="p-4">
      @include('messages.flash')
      @include('messages.errors')
      <form method="post" action="{{ url('lancamentos') }}">
        @csrf
        @include('lancamentos.form')
      </form>
    </div>
  </div>
@endsection

@section('javascripts_bottom')
    <script>
        $(document).ready(function() {
            $('.contas_select').select2();
        });
    </script>

@stop
