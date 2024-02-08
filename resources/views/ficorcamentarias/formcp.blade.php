<div class="card p-3">  
    <div class="form-row">
        <div class="form-group col-md-9">
            <label for="conta">Escolha um Tipo de conta: </label>
            <select class="contas_select form-control" name="tipoconta" id="tipoconta">   
              <option value=" ">Selecione o tipo de conta...</option>
                    @foreach($tiposdecontas as $tiposdeconta)
                      @if(old('tipoconta') != '')
                          <option value="{{ old('tipoconta') }}" 
                          {{ old('tipoconta') == $tiposdeconta->id ? 'selected' : '' }}>
                            {{ $tiposdeconta->descricao }}
                          </option>
                      @else
                        <option value="{{$tiposdeconta->id}}">{{ $tiposdeconta->descricao }}</option>
                      @endif
                    @endforeach
              </select>
        </div>
    <div class="form-row">
        <div class="form-group col-md-9">
            <label for="conta">Escolha uma Conta: </label>
            <select class="contas_select form-control" name="contas" id="conta" tabindex="1">           
                <option value=" ">&nbsp;</option>
                    @foreach($contas as $conta)
                        <option value="{{ $conta->id }}">
                        {{ $conta->nome }}
                        </option>
                    @endforeach
        </select>
        </div>
    <div class="form-group col-md-1">
        <label for="grupo">Grupo</label>
            <input type="text" class="form-control" name="grupo" value="{{ $ficorcamentaria->dotacao->grupo }}" placeholder="Ex:80">
    </div>
    <div class="form-group col-md-1">
        <label for="receita" class="checkbox-inline">Receita</label><br>
            <input type="checkbox" name="receita" id="receita" value="1">
    </div>
    @if($ficorcamentaria->debito != 0)
    <div class="form-group col-md-1">
        <label for="debito">Débito</label>
            <input type="text" class="form-control" name="debito" value="{{ $ficorcamentaria->debito ?? old('debito') }}" placeholder="[ Ex: 100,00 ]">
    </div>
    @else
    <div class="form-group col-md-1">
        <label for="credito">Crédito</label>
            <input type="text" class="form-control" name="credito" value="{{ $ficorcamentaria->credito ?? old('credito') }}" placeholder="[ Ex: 100,00 ]">
    </div>
    @endif
    <br>
    <div class="form-row">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="form-group col-md-12">
                <input type="hidden" name="ficorcamentaria_id" value="{{ $ficorcamentaria->id }}">
                    <input type="submit" class="btn btn-success" value="Salvar">
                    <input type="reset" class="btn btn-warning" value="Desfazer">
                </div>
            </div>
        </div>
    </div>
</div>

@section('javascripts_bottom')
<script type="text/javascript">
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
      function filtro(valor){
        if( valor ) {
          $.ajax({
            url:"{{ route('contrapartida.getContas') }}",
            type: 'post',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                search: valor,
            },
            beforeSend: function() {
              $('#conta').html('<option value="">Aguarde... </option>');
            },
            success: function( data ) {
                var options = '<option value="">Selecione a conta...</option>';
                for (var i = 0; i < data.length; i++) {
                options += '<option value="' + data[i].id + '">'
                    +data[i].nome + '</option>';
                }
                $("#conta").html(options);
            },
            complete: function(){
              $('#conta').val("{{ old('contas') }}");
            }
          });
        }
        else {
          $('#conta').html('<option value="">Selecione um Tipo de conta</option>');
        }
      }
      
      if( $("#tipoconta").val() ) filtro($("#tipoconta").val())

      $("#tipoconta").change(function () {
        filtro($(this).val())
      });
    });
  </script>
@stop