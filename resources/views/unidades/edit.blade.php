@extends('master')

@section('title')
  Editar Unidade
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Unidade</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/unidades/{{$unidade->id}}">
      @csrf
      @method('patch')
      @include('unidades.form')
    </form>
  </div>
</div>
@stop
