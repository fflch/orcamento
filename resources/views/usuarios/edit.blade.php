@extends('master')
@section('title')
  Usuários - Visualização e edição
@endsection
@section('content')
<div class="card p-3">
    <h2><strong>Usuários - Visualização e edição</strong></h2>
</div>
<br>
<div class="border rounded bg-light">
  <div class="p-4">
    @include('messages.flash')
    @include('messages.errors')
    <form method="post" action="/usuarios/{{$usuario->id}}">
      @csrf
      @method('patch')
      @include('usuarios.form')
    </form>
  </div>
</div>
<br>
<div class="border rounded bg-light">
  <div class="p-4">
    <h3 class="ml-2 mt-2">Vincular conta ao usuário:</h3>
    <form method="post" action="/usuarios/{{$usuario->id}}/storeContaUsuario">
      @csrf
      @method('post')
      @include('usuarios.secondform')
    </form>
  </div>
  <br>
  <div class="card p-3">
      <div class="form-group col-md-4"><b>Contas atualmente vinculadas a esse usuário:</b></div>
      <table class="table table-striped" border="0">
          <thead>
              <tr>
                  <th align="left">Conta</th>
                  <th align="left">Nome</th>
              </tr>
          </thead>
          <tbody>
          @foreach($contas_vinculadas as $conta)
              <tr>
                  <td>{{ $conta->conta->id }}</td>
                  <td>{{ $conta->conta->nome }}</td>
                  @can('Administrador')
                  <td align="center">
                      <form method="post" role="form" action="/usuarios/{{ $conta->id }}/destroyContaUsuario" >
                          @csrf
                          <input name="_method" type="hidden" value="DELETE">
                          <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Deseja realmente excluir a Conta x Usuário?');">Deletar</button>
                      </form>
                  </td>
                  @endcan
              </tr>
          @endforeach
          </tbody>
      </table>
  </div>
</div>
@stop