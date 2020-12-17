@extends('master')

@section('title')
  Editar Nota
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Nota</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/notas/{{$nota->id}}">
      @csrf
      @method('patch')
      @include('notas.form')
    </form>
  </div>
</div>
@stop
