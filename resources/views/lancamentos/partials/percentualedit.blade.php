<div class="form-row">
    <div id="container" class="col-sm form-group">
          @foreach($lancamento->contas as $pivot)
            <div class="row mb-1" id="conta{{ $loop->index }}">
              @if (count($contas) > 1)
                <select name="contas[]" class="btn btn-success mr-2">
              @endif
                  <option value="{{ $pivot->pivot->conta_id }}">
                      {{ $pivot->nome }}
                  </option>
                </select>
              <input name="percentual[]" type="number" value="{{ $pivot->pivot->percentual   }}">
              <button class="btn btn-primary float-left ml-2">+</button>
              <button class="btn btn-danger float-left ml-2">-</button>
            </div>
          @endforeach
        <div class="row mb-1" id="conta{{ count($lancamento->contas ?? ['']) }}"></div>
    </div>
</div>

@section('javascripts_bottom')
<script>
  $(document).ready( function () {
    let row_select = $("select[name^='contas']").length;

    $("#container").on("click", ".btn-primary", function(e){
      e.preventDefault();
      let new_row_select = row_select - 1;
      $("#conta" + row_select).html( $("#conta" + new_row_select).html() );
      $("#container").append('<div class="row mb-1" id="conta' + (row_select + 1)+ '"></div>');
      row_select++;
    });

    $("#container").on("click", ".btn-danger", function(e){
      e.preventDefault();
      if(row_select > 1){
        $("#conta" + (row_select - 1)).remove();
        $("#conta" + row_select).attr('id', 'conta' + (row_select - 1));
        row_select--;
      }
    });

  });
</script>
@endsection