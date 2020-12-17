@extends('master')

@section('title')
  Adicionar Lançamento
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
@stop
