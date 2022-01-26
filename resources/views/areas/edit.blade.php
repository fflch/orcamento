@extends('master')

@section('title')
Editar Área
@endsection

@section('content')
<div class="border rounded bg-light">
<h3 class="ml-2 mt-2">Editar Área</h3>
<div class="p-4">
@include('messages.flash')
@include('messages.errors')
<form method="post" action="/areas/{{$area->id}}">
@csrf
@method('patch')
@include('areas.form')
</form>
</div>
</div>
@stop
