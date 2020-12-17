@extends('master')

@section('title')
  Adicionar Área
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Área</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ url('areas') }}">
      @csrf
      @include('areas.form')
    </form>
  </div>
</div>
@stop
