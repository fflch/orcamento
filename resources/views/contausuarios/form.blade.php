<div class="form-row">
<div class="form-group col-md-6">
    <label for="conta">Conta</label>
<input class="form-control" list="id_conta" name="id_conta">
<datalist id="id_conta">
<option value="{{ $contausuario->id_conta ?? old('id_conta') }}">{{ $contausuario->conta->nome ?? old('conta_nome') }}</option>
        <option value=" ">----------</option>
@foreach($lista_contas as $lista_conta)
<option value="{{ $lista_conta->id }}">{{ $lista_conta->nome }}
  @endforeach
</datalist>
</div>

<div class="form-group col-md-6">
    <label for="usuario">Usuário</label>
<input class="form-control" list="id_usuario" name="id_usuario">
<datalist id="id_usuario">
<option value="{{ $contausuario->id_usuario ?? old('id_usuario') }}">{{ $contausuario->user->name ?? old('user_name') }}</option>
        <option value=" ">----------</option>
@foreach($lista_usuarios as $lista_usuario)
<option value="{{ $lista_usuario->id }}">{{ $lista_usuario->name }}
  @endforeach
</datalist>
</div>
</div>

<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar">
                <input type="reset" class="btn btn-warning" value="Desfazer">
            </div>
        </div>
    </div>
</div>