<table>
    @foreach($contas as $conta)
        <tr>
            <td><input {{ $conta->value ? 'checked' : null }} data-id="{{ $conta->id }}" type="checkbox" class="conta-enable"></td>
            <td>{{ $conta->nome }}</td>
            <td><input value="{{ $conta->value ?? null }}" {{ $conta->value ? null : 'disabled' }} data-id="{{ $conta->id }}" name="contas[{{ $conta->id }}]" type="text" class="conta-percentual form-control" placeholder="Percentual"></td>
        </tr>
    @endforeach
</table>

@section('javascripts_bottom')
    <script>
        $('document').ready(function () {
            $('.conta-enable').on('click', function () {
                let id = $(this).attr('data-id')
                let enabled = $(this).is(":checked")
                $('.conta-percentual[data-id="' + id + '"]').attr('disabled', !enabled)
                $('.conta-percentual[data-id="' + id + '"]').val(null)
            })
        });
    </script>
@endsection