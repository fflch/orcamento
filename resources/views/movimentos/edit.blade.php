@extends('master')
@section('title')
    Movimentos - Edição
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Movimentos - Edição</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
    <div class="p-4">
        @include('messages.flash')
        @include('messages.errors')
        <form method="post" action="/movimentos/{{$movimento->id}}">
            @csrf
            @method('patch')
            @include('movimentos.form')
        </form>
    </div>
</div>
@stop
