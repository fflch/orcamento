$lancamentos = Lancamento::all()->sort('id');

$lancamentos->saldo = 0.00;

foreach($lancamentos as $lancamento){
    if($lancamento->debito != 0.001){
        $lancamento->saldo = (float) $lancamento->saldo - (float) $lancamento->debito;    
    }
    if($lancamento->credito != 0.001){
        $lancamento->saldo = (float) $lancamento->saldo - (float) $lancamento->credito;    
    }
    $lancamento->save();
}

foreach($lancamentos as $lancamento){
    foreach($lancamento as $l){
        if($l->debito != 0.001){
            $l->saldo = (float) $l->debito - (float) $l->saldo;    
        }
        if($l->credito != 0.001){
            $l->saldo = (float) $l->credito - (float) $l->saldo;    
        }
        $l->save();
    }
}