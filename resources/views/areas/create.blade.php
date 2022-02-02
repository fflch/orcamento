@extends('master')
@section('title')
    Áreas - Inclusão
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Áreas - Inclusão</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
    <div class="p-4">
        @include('messages.flash')
        @include('messages.errors')
        <form method="post" action="{{ url('areas') }}">
            @csrf
            @include('areas.form')
        </form>
    </div>
</div>
@stop
