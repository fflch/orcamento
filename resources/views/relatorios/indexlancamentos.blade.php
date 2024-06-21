<div class="form-group col-md-6 p-3">
    <div class="card p-3">
        <h3><strong>Lançamentos</strong></h3>
    </div>
    <br> 
    <form method="get" action="/relatorios/lancamentos">
        @csrf
        @include('lancamentos.partials.filtro')
        <div class="form-row">
            <div class="form-group col-md-3">
                <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
            </div>
            <div class="form-group col-md-3">
                <input autocomplete="off" type="text" class="form-control datepicker data" name="data_inicial" value="01/01/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
            </div>
            <div class="form-group col-md-3">
                <input autocomplete="off" type="text" class="form-control datepicker data" name="data_final" value="31/12/{{ session('ano') }}" placeholder="[ Ex: 01/01/2020 ]">
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
