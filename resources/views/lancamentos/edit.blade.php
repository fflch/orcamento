@extends('master')
@section('title')
    Lançamentos: Edição
@endsection
@section('content')
<div class="border rounded bg-light">
    <h3 class="ml-2 mt-2">Editar Lançamento</h3>
    <div class="p-4">
        @include('messages.flash')
        @include('messages.errors')
        <form method="post" action="/lancamentos/{{$lancamento->id}}">
            @csrf
            @method('patch')
            @include('lancamentos.formedit')
        </form>
    </div>
</div>
@endsection
@section('javascripts_bottom')
<script>
    $(document).ready(function() {
        $('.contas_select').select2();
    });
</script>
@stop
