<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicOrcamentaria extends Model
{
    use HasFactory;
    protected $fillable = [
        'movimento_id',
        'dotacao_id',   
        'descricao',
        'observacao',
        'data',
        'empenho',
        'debito',
        'credito',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movimento(){
        return $this->belongsTo(Movimento::class);
    }

    public function dotacao(){
        return $this->belongsTo(DotOrcamentaria::class);
    }

    public function setDebitoAttribute($value){
        $this->attributes['debito'] = str_replace(',','.',$value);
    }
    
    public function getDebitoAttribute($value){
        return number_format($value, 2, ',', '');
    }

    public function getDebitoRawAttribute(){
        if($this->debito){
            return (float)str_replace(',','.',$this->debito);
        }
    }

    public function setCreditoAttribute($value){
        $this->attributes['credito'] = str_replace(',','.',$value);
    }
    
    public function getCreditoAttribute($value){
        return number_format($value, 2, ',', '');
    }

    public function getCreditoRawAttribute(){
        if($this->credito){
            return (float)str_replace(',','.',$this->credito);
        }
    }

    public function setSaldoAttribute($saldo){
        $this->attributes['saldo'] = str_replace(',', '.', $saldo);
    }

    public function getSaldoAttribute($saldo){
        return number_format($saldo, 2, ',', '.');
    }

    public function getDataAttribute($data) {
        return implode('/',array_reverse(explode('-',$data)));
    }
    
    public function setDataAttribute($data) {
        $this->attributes['data'] = implode('-',array_reverse(explode('/',$data)));
    }


    static function calculaSaldo($dotacao_id){
        $ficorcamentarias_dotacao = FicOrcamentaria::where('dotacao_id','=',$dotacao_id)->orderBy('data')->get();
        $saldo  = 0.00;
        foreach($ficorcamentarias_dotacao as $calcula_saldo){
            $saldo += $calcula_saldo->credito_raw - $calcula_saldo->debito_raw;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
        }
    }
}
