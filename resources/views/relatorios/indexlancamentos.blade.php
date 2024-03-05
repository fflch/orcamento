<div class="form-group col-md-6 p-3">
    <div class="card p-3">
        <h3><strong>Lançamentos</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/lancamentos">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-12">
                <select class="contas_select form-control" name="conta" tabindex="1">
                    <option value=" ">[ Informe a Conta ]</option>
                    @foreach($lista_contas_ativas as $lista_conta_ativa)
                    <option value="{{ $lista_conta_ativa->id }}" @if(old('conta_id') == $lista_conta_ativa->id) {{'selected'}} @endif>
                        {{ $lista_conta_ativa->nome }} ({{ $lista_conta_ativa->descricao}})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
            </div>
            <div class="form-group col-md-3">            
                <input type="checkbox" name="receita_lancamentos" id="receita_lancamentos" value="1" @if (isset($lancamento->id) and ($lancamento->receita === 1)) checked @endif >
                <label for="receita_lancamentos" class="checkbox-inline">Receita</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control datepicker data" name="data_inicial" value="01/12/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
            </div>
            <div class="form-group col-md-3">
                <input type="text" class="form-control datepicker data" name="data_final" value="31/12/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
            </div>
        </div>
        <div class="form-row">
        <div class="form-group col-md-1" align="right">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>
        </div>
    </form>
</div>
