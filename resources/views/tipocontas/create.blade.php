@extends('master')
@section('title')
    Adicionar Tipo de Conta
@endsection
@section('content')
<div class="border rounded bg-light">
    <h3 class="ml-2 mt-2">Adicionar Tipo de Conta</h3>
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
