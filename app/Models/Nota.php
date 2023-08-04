<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $fillable = [
        'texto',
        'tipo',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipoconta(){
        return $this->belongsTo(TipoConta::class);
    }

    public static function lista_descricoes(){
        $lista_descricoes = Nota::where('tipo','LIKE','Descri%')->orderBy('texto')->get();
        return $lista_descricoes;
    }

    public static function lista_observacoes(){
        $lista_observacoes = Nota::where('tipo','LIKE','Observa%')->orderBy('texto')->get();
        return $lista_observacoes;
    }

    public static function lista_tipos(){
        return[
            'Descrição',
            'Observação',
        ];
    }
}
