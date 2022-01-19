<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'movimento_id',
        'conta_id',
        'ficorcamentaria_id',
        'descricao',
        'receita',
        'observacao',
        'grupo',
        'data',
        'empenho',
        'debito',
        'credito',
        'user_id',
        'percentual1',
        'percentual2',
        'percentual3',
        'percentual4',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movimento(){
        return $this->belongsTo(Movimento::class);
    }

    public function conta(){
        return $this->belongsTo(Conta::class);
    }

    public function getDebitoRawAttribute(){
        if($this->debito){
            return (float)str_replace(',','.',$this->debito);
        }
    }

    public function getCreditoRawAttribute(){
        if($this->credito){
            return (float)str_replace(',','.',$this->credito);
        }
    }
    
    public function getDebitoAttribute($debito){
        return number_format($debito, 2, ',', '.');
    }

    public function getCreditoAttribute($credito){
        return number_format($credito, 2, ',', '.');
    }

    public function getSaldoAttribute($saldo){
        return number_format($saldo, 2, ',', '.');
    }

    public function setDebitoAttribute($debito){
        $this->attributes['debito'] = str_replace(',', '.', $debito);
    }

    public function setCreditoAttribute($credito){
        $this->attributes['credito'] = str_replace(',', '.', $credito);
    }

    public function setSaldoAttribute($saldo){
        $this->attributes['saldo'] = str_replace(',', '.', $saldo);
    }

    public function getDataAttribute($data) {
        return implode('/',array_reverse(explode('-',$data)));
    }
    
    public function setDataAttribute($data) {
        $this->attributes['data'] = implode('-',array_reverse(explode('/',$data)));
    }

    static function calculaSaldo($conta_id){
        $lancamentos_conta = Lancamento::where('conta_id','=',$conta_id)->orderBy('data')->get();
        $saldo  = 0.00;
        foreach($lancamentos_conta as $calcula_saldo){
            $saldo += $calcula_saldo->credito_raw - $calcula_saldo->debito_raw;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
        }
        return $saldo;
    }
}
