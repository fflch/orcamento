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

    public static function lista_contas_ativas(){
        $lista_contas_ativas = Conta::where('ativo','=','1')->orderBy('nome')->get();
        return $lista_contas_ativas;
    }

    public static function lista_contas_todas(){
        $lista_contas_todas = Conta::All()->orderBy('nome')->get();
        return $lista_contas_todas;
    }

    public static function nome_conta($conta_id){
        $nome_conta = Conta::where('id','=',$conta_id)->get();
        return $nome_conta;
    }

    public static function nome_conta_numero($numero){
        $nome_conta_numero = Conta::where('numero','=',$numero)->get();
        return $nome_conta_numero;
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
