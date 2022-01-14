<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoConta extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao',
        'cpfo',
        'relatoriobalancete',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function conta(){
        return $this->hasMany(Conta::class,'tipoconta_id','id');
    }

    public static function lista_tipos_contas(){
        $lista_tipos_contas = TipoConta::orderBy('descricao')->get();
        return $lista_tipos_contas;
    }

    public static function lista_contas_por_tipo($tipoconta_id){
        $lista_contas_por_tipo = Conta::where('tipoconta_id','=',$tipoconta_id)->orderBy('nome')->get();
        return $lista_contas_por_tipo;
    }

    public static function descricao_tipo_conta($tipoconta_id){
        $descricao_tipo_conta = TipoConta::where('id','=',$tipoconta_id)->value('descricao');
        return $descricao_tipo_conta;
    }
}
