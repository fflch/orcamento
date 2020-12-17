@extends('master')

@section('title')
  Adicionar Nota
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Nota</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ url('notas') }}">
      @csrf
      @include('notas.form')
    </form>
  </div>
</div>
@stop
