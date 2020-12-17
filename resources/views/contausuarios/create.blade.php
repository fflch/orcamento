@extends('master')

@section('title')
  Adicionar Conta x Usuário
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Adicionar Conta x Usuário</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="{{ url('contausuarios') }}">
      @csrf
      @include('contausuarios.form')
    </form>
  </div>
</div>
@stop
