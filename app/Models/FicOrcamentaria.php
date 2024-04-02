<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lancamento;

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

    public function contas(){
        return $this->belongsToMany(Conta::class)
                    ->withTimestamps();
    }

    /*
    static function calculaSaldo($ficorcamentaria, ){
        $ficorcamentarias_dotacao = FicOrcamentaria::where('dotacao_id','=',$dotacao_id)->orderBy('data')->get();
        $saldo  = 0.00;
        foreach($ficorcamentarias_dotacao as $calcula_saldo){
            $saldo += $calcula_saldo->credito_raw - $calcula_saldo->debito_raw;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
        }
    }
    
    
    public static function calculaSaldo($ficorcamentaria, $ficorcamentaria_last){
        if($ficorcamentaria_last){
            $saldo = (float)str_replace(',','.',$ficorcamentaria_last->saldo);
        } else {
            $saldo = 0.00;
        }
        $saldo += $ficorcamentaria->credito_raw - $ficorcamentaria->debito_raw;
        $ficorcamentaria->saldo = $saldo;
        $ficorcamentaria->update();
       
    }
    */
    
    public static function calculaSaldo(){
        $ficorcamentarias = FicOrcamentaria::all()->groupBy('id');

        $ficorcamentarias->saldo = 0.00;

        foreach($ficorcamentarias as $ficorcamentaria){
            foreach($ficorcamentaria as $ficha){
                $ficha->saldo = (float) $ficha->credito_raw - $ficha->debito_raw;    
                $ficha->save();
            }
        }
    }
}
