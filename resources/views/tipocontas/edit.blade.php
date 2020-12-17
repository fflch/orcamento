@extends('master')

@section('title')
  Editar Tipo de Conta
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Tipo de Conta</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/tipocontas/{{$tipoconta->id}}">
      @csrf
      @method('patch')
      @include('tipocontas.form')
    </form>
  </div>
</div>
@stop
