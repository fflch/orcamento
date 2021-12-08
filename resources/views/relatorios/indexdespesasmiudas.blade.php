<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Despesas Miúdas</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/despesas_miudas">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input type="text" class="form-control datepicker data" name="data_inicial" value="01/01/{{ $movimento_ativo->ano }}">&nbsp;
        <input type="text" class="form-control datepicker data" name="data_final" value="31/12/{{ $movimento_ativo->ano }}">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>
