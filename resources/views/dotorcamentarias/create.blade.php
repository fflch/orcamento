@extends('master')
lancamentos
@section('title')
  Adicionar Dotação Orçamentária
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Dotação Orçamentária</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ url('dotorcamentarias') }}">
      @csrf
      @include('dotorcamentarias.form')
    </form>
  </div>
</div>
@stop
