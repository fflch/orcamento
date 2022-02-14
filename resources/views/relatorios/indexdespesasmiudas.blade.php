<div class="form-group col-md-3 p-3">
    <div class="card p-3">
        <h3><strong>Despesas Miúdas</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/despesas_miudas">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-5">
                <input type="text" class="form-control datepicker data" name="data_inicial" value="01/01/{{ session('ano') }}" placeholder="[ Informe a Data Inicial ]">&nbsp;
            </div> 
            <div class="form-group col-md-5">                  
                <input type="text" class="form-control datepicker data" name="data_final" value="31/12/{{ session('ano') }}" placeholder="[ Informe a Data Final ]">
            </div> 
            <div class="form-group col-md-2" align="right">                   
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success"><strong>OK</strong></button>
                </span>
            </div>                
        </div>
    </form>
</div>
