@extends('master')
@section('title')
  Unidade - Edição
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Unidade - Edição</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
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
