@extends('master')

@section('title')
  Editar Conta
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Conta</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/contas/{{$conta->id}}">
      @csrf
      @method('patch')
      @include('contas.form')
    </form>
  </div>
</div>
@stop
