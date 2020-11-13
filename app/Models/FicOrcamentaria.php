<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicOrcamentaria extends Model
{
    use HasFactory;
    protected $fillable = ['descricao','observacao','data', 'empenho','debito','credito'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movimento(){
        return $this->belongsTo(Movimento::class);
    }

    public function dotacao(){
        return $this->belongsTo(DotOrcamentaria::class);
    }

    public function getDebitoAttribute($debito){
        return number_format($debito, 2, ',', '.');
    }

    public function setDebitoAttribute($debito){
        $this->attributes['debito'] = str_replace(',', '.', $debito);
    }

    public function getCreditoAttribute($credito){
        return number_format($credito, 2, ',', '.');
    }

    public function setCreditoAttribute($credito){
        $this->attributes['credito'] = str_replace(',', '.', $credito);
    }

    public function getSaldoAttribute($saldo){
        return number_format($saldo, 2, ',', '.');
    }

    public function setSaldoAttribute($saldo){
        $this->attributes['saldo'] = str_replace(',', '.', $saldo);
    }
}
