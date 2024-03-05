<div class="card p-6">  
    <div class="card-header">
        <label for="tipos_contas">Contas</label>
    </div>
    <div class="form-row">
        @foreach($contas_filtradas_objs as $contas_filtradas_obj)
            <div class="form-group col-md-2 p-3">
                <label class="checkbox-inline" for="contaid[{{ $contas_filtradas_obj->id }}]">
                <input type="checkbox" id="contaid[{{ $contas_filtradas_obj->id }}]" name="contaid[]" value="{{ $contas_filtradas_obj->id }}" tabindex="6"
                @if (isset($conta->id) and ($conta->ativo === 1)) checked @endif >    
                {{ $contas_filtradas_obj->nome }} - {{ $contas_filtradas_obj->tipoconta->descricao }}         
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