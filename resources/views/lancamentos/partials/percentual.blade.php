<div class="card p-3">  
  <div class="form-row">
        <div class="form-group col-md-9">
            <label for="conta">Escolha um Tipo de conta: </label>
            <select class="contas_select form-control" name="tipoconta" id="tipoconta">
                <option value=" ">Selecione o tipo de conta...</option>
                    @foreach($tiposdecontas as $tiposdeconta)
                        <option value="{{ $tiposdeconta->id }}">{{ $tiposdeconta->descricao }}</option>
                    @endforeach
            </select>
        </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-9">
      <label for="conta">Escolha uma Conta: </label>
        <select class="contas_select form-control" name="contas" id="conta" tabindex="1">
          <option value=" ">&nbsp;</option>
            @foreach($contas as $conta)
              <option value="{{ $conta->id }}">{{ $conta->nome }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-1">
      <label for="grupo">Percentual</label>
          <input type="text" class="form-control" name="percentual">
    </div>
  </div>
</div>
<br>
    <div class="form-row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group col-md-12">
                    <input type="hidden" name="id" value="{{ $lancamento->id }}">
                    <input type="submit" class="btn btn-success" value="Salvar">
                    <input type="reset" class="btn btn-warning" value="Desfazer">
                </div>
            </div>
        </div>
    </div>
@section('javascripts_bottom')
<script type="text/javascript">
  // CSRF Token
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
      $("#tipoconta").change(function () {
        if( $(this).val() ) {
          $.ajax({
            url:"{{ route('percentual.getLancamentoContas') }}",
            type: 'post',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                search: $(this).val(),
            },
            beforeSend: function() {
              $('#conta').html('<option value="">Aguarde... </option>');
            },
            success: function( data ) {
                var options = '<option value="">Selecione a Conta</option>';
                for (var i = 0; i < data.length; i++) {
                options += '<option value="' + data[i].id + '">'
                    +data[i].nome + '</option>';
                }
                $("#conta").html(options);
            }
          });
        }
        else {
          $('#conta').html('<option value="">Selecione um Tipo de conta</option>');
        }
      });
    });
</script>
@endsection