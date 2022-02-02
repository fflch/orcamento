@extends('master')
@section('title')
    Editar Área
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Áreas - Edição</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
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
