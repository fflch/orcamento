@extends('master')
@section('title')
    Movimentos - Inclusão
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Movimentos - Inclusão</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
    <div class="p-4">
        @include('messages.flash')
        @include('messages.errors')
        <form method="post" action="{{ url('movimentos') }}">
            @csrf
            @include('movimentos.form')
        </form>
    </div>
</div>
@stop
