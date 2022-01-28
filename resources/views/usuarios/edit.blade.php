@extends('master')
@section('title')
  Usuários - Edição
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Usuários - Edição</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
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
