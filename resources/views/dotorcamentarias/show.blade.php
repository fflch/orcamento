@extends('master')

@section('content_header')
  <h1>Dotação Orçamentária: {{ $dotorcamentaria->ano }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{ route('dotorcamentarias.edit',$dotorcamentaria->id) }}" class="btn btn-success">Editar</a>

</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Dotação</b>: {{ $dotorcamentaria->dotacao }}</li>
        <li class="list-group-item"><b>Grupo</b>: {{ $dotorcamentaria->grupo }}</li>
        <li class="list-group-item"><b>Descrição do Grupo</b>: {{ $dotorcamentaria->descricaogrupo }}</li>
        <li class="list-group-item"><b>Item</b>: {{ $dotorcamentaria->item }}</li>
        <li class="list-group-item"><b>Descrição do Item</b>: {{ $dotorcamentaria->descricaoitem }}</li>
        <li class="list-group-item"> 
        @if ($dotorcamentaria->receita == 1)
                      X
                    @endif 
         <b> Receita</b></li>
         <li class="list-group-item"><b>Cadastrado/Alterado por</b>: {{ $dotorcamentaria->user->name ?? '' }}</li>
    </ul>
</div>

@stop