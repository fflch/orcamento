<div class="form-group">
    <label for="dotacao">Dotação</label>
    <input type="text" class="form-control" name="dotacao" value="{{ $dotorcamentaria->dotacao ?? old('dotacao') }}" placeholder="Ex: 11111">
</div>

<div class="form-group">
    <label for="grupo">Grupo</label>
    <input type="text" class="form-control" name="grupo" value="{{ $dotorcamentaria->grupo ?? old('grupo') }}" placeholder="Ex: 11111">
</div>

<div class="form-group">
    <label for="descricaogrupo">Descrição do Grupo</label>
    <input type="text" class="form-control" name="descricaogrupo" value="{{ $dotorcamentaria->descricaogrupo ?? old('descricaogrupo') }}" placeholder="Ex: 11111">
</div>

<div class="form-group">
    <label for="item">Item</label>
    <input type="text" class="form-control" name="item" value="{{ $dotorcamentaria->item ?? old('item') }}" placeholder="Ex: 11111">
</div>

<div class="form-group">
    <label for="descricaoitem">Descrição do Item</label>
    <input type="text" class="form-control" name="descricaoitem" value="{{ $dotorcamentaria->descricaoitem ?? old('descricaoitem') }}" placeholder="Ex: 11111">
</div>

<div class="form-group">
    <label class="checkbox-inline"><input type="checkbox" name="receita" value="1"
        @if (isset($dotorcamentaria->id) and ($dotorcamentaria->receita === 1))
                checked
        @endif >
        <label for="ativo"> Receita</label></label>
</div>

<div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Enviar">
            </div>
        </div>
    </div>
</div>