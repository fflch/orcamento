<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conta;
use Illuminate\Support\Facades\Schema;

class Lancamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'movimento_id',
        'ficorcamentaria_id',
        'descricao',
        'receita',
        'observacao',
        'grupo',
        'data',
        'empenho',
        'debito',
        'credito',
        'user_id'
    ];

    public static function campos(){
        return collect([
            'data' => 'Data',
            'descricao' => 'Descrição',
            'observacao' => 'Observação',
            'grupo' => 'Grupo',
            'ficorcamentaria_id' => 'CP',
            'receita' => 'REC',
            'debito' => 'Débito',
            'credito' => 'Crédito',
            'saldo' => 'Saldo',
        ]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movimento(){
        return $this->belongsTo(Movimento::class);
    }

    public function setCreditoAttribute($value){
        $this->attributes['credito'] = str_replace(',','.',$value);
    }
    
    public function getCreditoAttribute($value){
        return number_format($value, 2, ',', '');
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

    public function getCreditoRawAttribute(){
        if($this->credito){
            return (float)str_replace(',','.',$this->credito);
        }
    }

    public function getDataAttribute($data) {
        return implode('/',array_reverse(explode('-',$data)));
    }
    
    public function setDataAttribute($data) {
        $this->attributes['data'] = implode('-',array_reverse(explode('/',$data)));
    }

    public function contas(){
        return $this->belongsToMany(Conta::class)
                    ->withPivot(['percentual'])
                    ->withTimestamps();
    }
}