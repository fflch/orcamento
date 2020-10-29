<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoConta extends Model
{
    use HasFactory;
    protected $fillable = ['descricao'];

    public static function lista_tipos_contas(){
        $lista_tipos_contas = TipoConta::all()->sortBy('descricao');
        return $lista_tipos_contas;
    }
}
