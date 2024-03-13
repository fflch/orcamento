<div class="table-responsive">
    <table class="table table-striped" border="0">
        <thead>
            <tr>
                <th>Débito total até {{ $hoje }}</th>
                <th>Crédito total até {{ $hoje }}</th>
                <th>Saldo total até {{ $hoje }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><font color="red"><strong>{{ number_format($total_debito, 2, ',', '.') ?? '' }}</strong></font></td>
                <td><font color="blue"><strong>{{ number_format($total_credito, 2, ',', '.') }}</strong></font></td>
                <td>
                @if(($total_credito - $total_debito) == 0.00)
                    <font color="black">
                @elseif(($total_credito - $total_debito) > 0.00)
                    <font color="green">
                @else
                    <font color="red">
                @endif
                <strong>{{ number_format(($total_credito - $total_debito), 2, ',', '.') }}</strong></font></td>
            </tr>
        </tbody>
    </table>