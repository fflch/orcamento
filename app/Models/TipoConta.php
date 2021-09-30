<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoConta extends Model
{
    use HasFactory;
    protected $fillable = ['descricao','cpfo','relatoriobalancete','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipo_contas(){
        return $this->hasMany(Conta::class,'tipoconta_id','id');
    }

    public static function lista_tipos_contas(){
        $lista_tipos_contas = TipoConta::all()->sortBy('descricao');
        return $lista_tipos_contas;
    }

    public static function descricao_tipo_conta($conta_id){
        $descricao_tipo_conta = TipoConta::where('id','=',$conta_id)->value('descricao');
        return $descricao_tipo_conta;
    }
    
}
