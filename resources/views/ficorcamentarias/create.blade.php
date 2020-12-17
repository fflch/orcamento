@extends('master')

@section('title')
  Adicionar Ficha Orçamentária
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Ficha Orçamentária</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ url('ficorcamentarias') }}">
      @csrf
      @include('ficorcamentarias.form')
    </form>
  </div>
</div>
@stop
