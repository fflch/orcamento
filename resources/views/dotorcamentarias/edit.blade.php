@extends('master')

@section('title')
  Editar Dotação Orçamentária
@endsection

@section('content')
<div class="border rounded bg-light">
  <h3 class="ml-2 mt-2">Editar Dotação Orçamentária</h3>
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/dotorcamentarias/{{$dotorcamentaria->id}}">
      @csrf
      @method('patch')
      @include('dotorcamentarias.form')
    </form>
  </div>
</div>
@stop
