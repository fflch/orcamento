<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $fillable = ['texto','tipo'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipoconta(){
        return $this->belongsTo(TipoConta::class);
    }

    public static function lista_descricoes(){
        //$lista_descricoes = Nota::where('tipo','LIKE','%Descri%')->orderBy('texto');
        $lista_descricoes = Nota::all()->sortBy('texto');

        return $lista_descricoes;
    }

    public static function lista_observacoes(){
        //$lista_observacoes = Nota::where('tipo','LIKE','%Observa%')->orderBy('texto');
        $lista_observacoes = Nota::all()->sortBy('texto');

        return $lista_observacoes;
    }
}
