<div class="form-row">
    <div class="form-group col-md-6">
        <label for="Tipo">Tipo</label>
        <select class="form-control" name="tipo" tabindex="2">
            <option value="{{ $nota->tipo ?? old('tipo') }}">{{ $nota->tipo ?? old('tipo') }}</option>
            <option value=null>----------</option>
            @foreach($lista_tipos as $lista_tipo)
                <option value="{{ $lista_tipo ?? old('tipo') }}">{{ $lista_tipo ?? old('tipo') }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <label for="texto">Texto</label>
        <input type="text" class="form-control" name="texto" value="{{ $nota->texto ?? old('texto') }}" placeholder="[ Ex: Suplementação de Cursos ]" maxlength = "190" tabindex="3">
    </div>
</div>
<div class="form-row">
    <div class="panel panel-body panel-default">
        <div class="form-group col-md-12">
            <input type="submit" class="btn btn-primary" value="Salvar" tabindex="4">
            <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="5">
        </div>
    </div>
</div>
