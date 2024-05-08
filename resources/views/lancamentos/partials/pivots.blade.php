@php 
    $pivots = \App\Models\ContaLancamento::where('lancamento_id',$lancamento->id)->get(); 
@endphp

@foreach($pivots as $pivot)
    <br>
    <small style="color:green;">
        {{ number_format((float)($valor * $pivot->percentual/100),2, ',', '.') }}
        ({{ $pivot->percentual }}%) para conta
        <b>{{ \App\Models\Conta::find($pivot->conta_id)->nome }}</b>
    </small>
@endforeach