@extends('master')

@section('title')
  Editar Usuário
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Usuário</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/usuarios/{{$usuario->id}}">
      @csrf
      @method('patch')
      @include('usuarios.form')
    </form>
  </div>
</div>
@stop
