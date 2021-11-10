<div class="form-row">
<div class="form-group col-md-4">
    <label for="dotacao">Dotação</label>
    <input type="text" class="form-control" name="dotacao" value="{{ $dotorcamentaria->dotacao ?? old('dotacao') }}" placeholder="[ Ex: 1220988 ]" maxlength="9" tabindex="1">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
    <label for="grupo">Grupo</label>
    <input type="text" class="form-control" name="grupo" value="{{ $dotorcamentaria->grupo ?? old('grupo') }}" placeholder="[ Ex: 081 ]" tabindex="2">
</div>

<div class="form-group col-md-8">
    <label for="descricaogrupo">Descrição do Grupo</label>
    <input type="text" class="form-control" name="descricaogrupo" value="{{ $dotorcamentaria->descricaogrupo ?? old('descricaogrupo') }}" placeholder="[ Ex: Manutenção de Edifícios - Orçamento ]" tabindex="3">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-4">
    <label for="item">Item</label>
    <input type="text" class="form-control" name="item" value="{{ $dotorcamentaria->item ?? old('item') }}" placeholder="[ Ex: 1220988 ]" maxlength="9" tabindex="4">
</div>

<div class="form-group col-md-8">
    <label for="descricaoitem">Descrição do Item</label>
    <input type="text" class="form-control" name="descricaoitem" value="{{ $dotorcamentaria->descricaoitem ?? old('descricaoitem') }}" placeholder="[ Ex: Serviços de Limpeza, Vigilância e Outros - PJ ]" tabindex="5">
</div>
</div>

<div class="form-row">
<div class="form-group col-md-1">
    <label class="checkbox-inline" for="receita">Receita<br>
    <input type="checkbox" id="receita" name="receita" value="1" tabindex="6"
        @if (isset($dotorcamentaria->id) and ($dotorcamentaria->receita === 1))
                checked
        @endif >
        </label>
</div>
<div class="form-group col-md-1">
    <label class="checkbox-inline" for="ativo">Ativo<br>
    <input type="checkbox" id="ativo" name="ativo" value="1" tabindex="7" 
        @if (isset($dotorcamentaria->id) and ($dotorcamentaria->ativo === 1))
        checked
        @endif >
        </label>
</div>
</div>

<div class="form-row">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group col-md-12">
                <input type="submit" class="btn btn-primary" value="Salvar" tabindex="8">
                <input type="reset" class="btn btn-warning" value="Desfazer" tabindex="9">
            </div>
        </div>
    </div>
</div>
