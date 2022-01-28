@extends('master')
@section('title')
    Tipos de Contas - Inclusão
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Tipos de Contas - Inclusão</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
    <div class="p-4">
        @include('messages.flash')
        @include('messages.errors')
        <form method="post" action="{{ url('tipocontas') }}">
            @csrf
            @include('tipocontas.form')
        </form>
    </div>
</div>
@stop
