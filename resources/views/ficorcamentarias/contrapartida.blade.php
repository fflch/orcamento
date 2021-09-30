@extends('master')

@section('title')
  Adicionar Contra-Partida da Ficha Orçamentária
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Contra-Partida da Ficha Orçamentária</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ route('ficorcamentarias.store') }}">
      @csrf
      @include('ficorcamentarias.formcp')
    </form>
  </div>
</div>
@stop
