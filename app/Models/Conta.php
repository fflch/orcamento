<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Conta extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipoconta_id',
        'nome',
        'email',
        'numero',
        'ativo',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipoconta(){
        return $this->belongsTo(TipoConta::class);
    }

    public static function lista_contas_ativas(){
        $lista_contas_ativas = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->select('contas.id', 'contas.nome', 'tipo_contas.descricao')
            ->where('ativo','=','1')
            ->groupBy('contas.id', 'contas.nome', 'tipo_contas.descricao')
            ->orderBy('nome')
            ->get();
        return $lista_contas_ativas;
    }

    public static function lista_contas_todas(){
        $lista_contas_todas = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->select('contas.nome', 'tipo_contas.descricao')
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->orderBy('nome')
            ->get();
        return $lista_contas_todas;
    }

    public static function nome_conta($conta){
        return Conta::select('nome')->where('id', $conta)->first()->nome;
    }

    public static function nome_conta_numero($numero){
        $nome_conta_numero = Conta::where('numero','=',$numero)->get();
        return $nome_conta_numero;
    }

    public function lancamentos(){
        return $this->belongsToMany(Lancamento::class)
                    ->withPivot(['percentual'])
                    ->withTimestamps();
    }

    public function conta_usuarios()
    {
        return $this->belongsToMany(User::class,'conta_usuarios', 'id_conta', 'id_usuario')
                ->withTimestamps()
                ->withPivot([
                    'created_at',
                ]);
    }
}
