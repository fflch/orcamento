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
<br>
<div class="form-row">
    <div class="panel panel-body panel-default">
        <div class="form-group col-md-12">
            <input type="hidden" name="id_usuario" value="{{ $usuario->id }}">
            <input type="submit" class="btn btn-success" value="Vincular conta" tabindex="7">
        </div>
    </div>
</div>