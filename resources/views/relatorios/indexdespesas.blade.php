<div class="form-group col-md-3 p-3">
    <div class="card p-3">
        <h3><strong>Despesas</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/despesas">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-12">
                <select class="areas_select form-control" name="area_id" tabindex="2">
                    <option value=" ">[ Informe a Área ]</option>
                    @foreach($lista_areas as $lista_area)
                    <option value="{{ $lista_area->id }}">
                        {{ $lista_area->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-10">
                <select name="Descricao" id="select2" class="form-control">
                    <option value="Despesas com Almoxarifado">Despesas com Almoxarifado</option>
                    <option value="Despesas com Servi&ccedil;os Postais">Despesas com Servi&ccedil;os Postais</option>
                    <option value="Despesas Mi&uacute;das">Despesas Mi&uacute;das</option>
                    <option value="Despesas com Material de Consumo">Despesas com Material de Consumo</option>
                </select>
            </div>
            <div class="form-group col-md-2" align="right">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>
        </div>
    </form>
</div>
