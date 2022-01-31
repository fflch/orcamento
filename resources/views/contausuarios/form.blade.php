<div class="form-row">
    <div class="form-group col-md-12">
        <label for="usuario_id">Usuário</label>
        <select class="usuarios_select form-control" name="usuario_id" tabindex="1">
            <option value=" ">&nbsp;</option>
            @foreach($lista_usuarios as $lista_usuario)
                <option value="{{ $lista_usuario->id }}" @if(old('usuario_id') == $lista_usuario->id) {{'selected'}}
                    @else {{($contausuario->id_usuario === $lista_usuario->id ) ? 'selected' : ''}} @endif>
                    {{ $lista_usuario->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="card p-6">  
    <div class="card-header">
        <label for="tipos_contas">Contas</label>
    </div>  
    <div class="form-row">
        @foreach($lista_contas_ativas as $lista_conta_ativa)
            <div class="form-group col-md-2 p-3">
                <label class="checkbox-inline" for="contaid[{{ $lista_conta_ativa->id }}]">
                <input type="checkbox" id="contaid[{{ $lista_conta_ativa->id }}]" name="contaid[]" value="{{ $lista_conta_ativa->id }}" tabindex="6"
                @if (isset($conta->id) and ($conta->ativo === 1)) checked @endif >    
                {{ $lista_conta_ativa->nome }}
                </label>                                              
            </div>
        @endforeach
    </div>
</div>
<div class="form-row">
    <div class="panel panel-body panel-default">
        <div class="form-group col-md-12">
            <input type="submit" class="btn btn-primary" value="Salvar" tabindex="7">
            <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="8">
        </div>
    </div>
</div>

<!--input id="features" name="feature[{{$feature->id}}]" type="checkbox" value="1"  @if (old('feature[$feature->id]') == "1") checked @endif-->
