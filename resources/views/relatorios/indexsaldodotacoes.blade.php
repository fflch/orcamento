<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Saldo de Dotações</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/saldo_dotacoes">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>
