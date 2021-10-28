<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;
    protected $fillable = ['tipoconta_id','area_id','nome','email','numero','ativo','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function tipoconta(){
        return $this->belongsTo(TipoConta::class);
    }

    public static function lista_contas(){
        $lista_contas = Conta::where('ativo','=','1')->orderBy('nome')->get();
        return $lista_contas;
    }

    public static function nome_conta($conta_id){
        $nome_conta = Conta::where('id','=',$conta_id)->get();
        return $nome_conta;
    }

    public function lancamento(){
        return $this->hasMany(Lancamento::class);
    }

    public function contas_usuarios()
    {
        return $this->belongsToMany(User::class,'contas_usuarios')
                ->using(ContaUsuario::class)
                ->withTimestamps()
                ->withPivot([
                    'created_at'
                ]);
    }
}
