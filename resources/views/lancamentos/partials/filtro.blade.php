  <div class="form-row">
        <div class="form-group col-md-9">
            <label for="conta">Escolha um Tipo de conta: </label>
              <select class="tipocontas_select form-control" name="tipoconta" id="tipoconta">
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
  </div>
@section('javascripts_bottom')
<script type="text/javascript">
  // CSRF Token
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
      function filtro(valor){
        if( valor ) {
          $.ajax({
            url:"{{ route('percentual.getLancamentoContas') }}",
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

    $(document).ready(function() {
        $('.tipocontas_select').select2();
        $('.contas_select').select2();
    });
</script>
@endsection

