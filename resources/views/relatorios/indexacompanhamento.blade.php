<div class="form-group col-md-3 p-3">
    <div class="card p-3">
        <h3><strong>Acompanhamento</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/acompanhamento">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-9">
                <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
            </div>
            <div class="form-group col-md-3" align="right">
                <input type="checkbox" name="receita_acompanhamento" id="receita_acompanhamento" value="1" @if (isset($lancamento->id) and ($lancamento->receita === 1)) checked @endif >
                <label for="receita_acompanhamento" class="checkbox-inline">Receita</label>
            </div>
        </div>        
        <div class="form-row">
            <div class="form-group col-md-9">
                <input autocomplete="off" type="text" class="form-control datepicker data" name="data" value="31/12/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
            </div>
            <div class="form-group col-md-3" align="right">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>
        </div>
    </form>
</div>
