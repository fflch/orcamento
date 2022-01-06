<div class="form-group col-md-3 p-3">
    <div class="card p-3">
        <h3><strong>Saldo de Contas</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/saldo_contas">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-9">
                <select class="tipocontas_select form-control" name="tipoconta_id">
                    <option value=" ">[ Informe o Tipo de Conta ]</option>
                    @foreach($lista_tipos_contas as $lista_tipo_conta)
                        <option value="{{ $lista_tipo_conta->id }}"> 
                            {{ $lista_tipo_conta->descricao }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3" align="right">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>
        </div>
    </form>
</div>
