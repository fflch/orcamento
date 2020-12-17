@extends('master')

@section('title')
  Editar Ficha Orçamentária
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Ficha Orçamentária</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/ficorcamentarias/{{$ficorcamentaria->id}}">
      @csrf
      @method('patch')
      @include('ficorcamentarias.form')
    </form>
  </div>
</div>
@stop
