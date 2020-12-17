@extends('master')

@section('title')
  Editar Movimento
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Movimento</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/movimentos/{{$movimento->id}}">
      @csrf
      @method('patch')
      @include('movimentos.form')
    </form>
  </div>
</div>
@stop
