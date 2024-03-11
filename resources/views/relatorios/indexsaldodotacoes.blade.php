<div class="form-group col-md-3 p-3">
    <div class="card p-3">
        <h3><strong>Saldo - Dotações</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/saldo_dotacoes">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-9">
                <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
            </div>
            <div class="form-group col-md-3" align="right">
                <input type="checkbox" name="receita_dotacao" id="receita_dotacao" value="1">
                <label for="receita_dotacao" class="checkbox-inline">Receita</label>
            </div>
            <div class="form-group col-md-11" align="right">            
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>
        </div>
    </form>
</div>
