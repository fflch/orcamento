<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimento extends Model
{
    use HasFactory;
    protected $fillable = [
        'ano',
        'ativo',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lancamento(){
        return $this->hasMany('App\Models\Lancamento');
    }

    public function ficha_orcamentaria(){
        return $this->hasMany('App\Models\FicOrcamentaria');
    }

    public static function movimento_ativo(){
        $movimento_ativo = Movimento::where('ativo','=','1')->get();
        return $movimento_ativo;
    }

    public static function movimento_anos(){
        $movimento_anos = Movimento::get('ano');
        return $movimento_anos;
    }

    public static function anos(){
        return range(date('Y'), 2008, -1);
    }
}
