<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Acompanhamento</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/acompanhamento">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input type="text" class="form-control" name="grupo" value="{{ old('grupo') }}" placeholder="[ Informe o Grupo ]">
        <label for="receita_acompanhamento" class="checkbox-inline">Receita</label><br>
        <input type="checkbox" name="receita_acompanhamento" id="receita_acompanhamento" value="1" @if (isset($lancamento->id) and ($lancamento->receita === 1)) checked @endif >
        <input type="text" class="form-control" name="referencia" value=" - Outubro/2021" placeholder="[ Referência ]">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>
