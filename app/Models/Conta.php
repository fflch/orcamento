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
        $lista_contas = Conta::all()->sortBy('nome');
        return $lista_contas;
    }

}
