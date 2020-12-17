@extends('master')

@section('title')
  Editar Conta x Usuário
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Conta x Usuário</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/contausuarios/{{$contausuario->id}}">
      @csrf
      @method('patch')
      @include('contausuarios.form')
    </form>
  </div>
</div>
@stop
