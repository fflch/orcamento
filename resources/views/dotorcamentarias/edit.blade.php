@extends('master')
@section('title')
    Dotações Orçamentárias - Edição
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Dotações Orçamentárias - Edição</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
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
