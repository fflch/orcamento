@extends('master')
@section('title')
    Projetos Especiais - Importação
@stop
@section('content')
  @include('messages.flash')
  @include('messages.errors')
<div class="card p-3">
    <h2><strong>Projetos Especiais - Importação</strong></h2>
</div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Grupo</th>
        <th scope="col">Conta</th>
        <th scope="col">Saldo</th>
      </tr>
    </thead>
    <tbody>
      @foreach($projetos as $projeto)
      <tr>
        <td>{{ $projeto->grupo }}</td>
        <td>{{ $projeto->nome }}</td>
        <td>{{ number_format($projeto->total, 2, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="alert alert-danger w-50 d-flex" role="alert">
  <label class="mt-1 pt-1">Este procedimento importará os saldos das contas dos Projetos Especiais do ano anterior à <b>{{ $ano }}.</b></label>
  <form class="float-right" method="post" action="/importacao">
    @csrf
    <button type="submit" class="btn btn-danger ml-5"><strong>Importar</strong></button>
  </form>
</div>
@endsection
