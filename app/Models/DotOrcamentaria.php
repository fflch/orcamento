<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DotOrcamentaria extends Model
{
    use HasFactory;
    protected $fillable = ['dotacao','grupo','descricaogrupo','item','descricaoitem','receita','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function lista_dotorcamentarias(){
        $lista_dotorcamentarias = DotOrcamentaria::all()->sortBy('dotacao');
        return $lista_dotorcamentarias;
    }

}
