<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimento extends Model
{
    use HasFactory;
    protected $fillable = ['ano','concluido','ativo'];

    public static function movimento_ativo(){
        $movimento_ativo = Movimento::where('ativo','=','1')->first();
        //dd($movimento_ativo);
        return $movimento_ativo;
    }
}
