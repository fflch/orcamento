<div class="form-row">
    <div class="form-group col-md-1">
        <label for="numero">Número USP</label>
        <input type="text" class="form-control" name="codpes" value="{{ $usuario->codpes ?? old('codpes') }}" placeholder="[ Ex: 08 ]" tabindex="1" disabled>
    </div>
    <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="name" value="{{ $usuario->name ?? old('name') }}" placeholder="[ Ex: Faculdade de Filosofia, Letras e Ciências Humanas ]" tabindex="2" disabled>
    </div>
    <div class="form-group col-md-3">
        <label for="departamento">E-mail</label>
        <input type="text" class="form-control" name="email" value="{{ $usuario->email ?? old('email') }}" placeholder="[ Ex: seu_nome@usp.br ]" tabindex="3" disabled>
    </div>
    <div class="form-group col-md-2">
        <label for="Perfil">Perfil</label>
        <select class="form-control" name="perfil" tabindex="4">
        <option value="{{ $usuario->perfil ?? old('perfil') }}">{{ $usuario->perfil ?? old('perfil') }}</option>
        <option value=null>----------</option>
        @foreach($lista_perfis as $lista_perfil)
            <option value="{{ $lista_perfil ?? old('perfil') }}">{{ $lista_perfil ?? old('perfil') }}</option>
        @endforeach
        </select>
    </div>
</div>
<div class="form-row">
    <div class="panel panel-body panel-default">
        <div class="form-group col-md-12">
            <input type="submit" class="btn btn-primary" value="Salvar" tabindex="5">
            <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="6">
        </div>
    </div>
</div>
