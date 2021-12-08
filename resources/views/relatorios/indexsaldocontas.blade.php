<div class="form-group col-md-3 p-3">
  <div class="card p-3">
    <h3><strong>Saldo de Contas</strong></h3>
  </div>
  <br> 
  <form method="get" action="/relatorios/saldo_contas">
    @csrf
    <div class="row">
      <div class="col-sm input-group">
        <input list="tipocontas" name="tipoconta_id" id="tipoconta_id" class="form-control" value="" placeholder="[ Informe o Tipo de Conta ]">
        <datalist id="tipocontas">
          @foreach($lista_tipos_contas as $lista_tipo_conta)
            <option value="{{ $lista_tipo_conta->id }}">{{ $lista_tipo_conta->descricao }}
          @endforeach
        </datalist>
        <span class="input-group-btn">
          <button type="submit" class="btn btn-success"><strong>OK</strong></button>
        </span>
      </div>
    </div>
  </form>
</div>
