<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DotOrcamentaria extends Model
{
    use HasFactory;
    protected $fillable = ['dotacao','grupo','descricaogrupo','item','descricaoitem','receita','ativo','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ficha_orcamentaria(){
        //return $this->hasMany('App\Models\FicOrcamentaria');
        return $this->hasMany(FicOrcamentaria::class,'dotacao_id','id');
    }

    public static function lista_dotorcamentarias(){
        $lista_dotorcamentarias = DotOrcamentaria::where('ativo','=','1')->orderBy('dotacao')->get();
        return $lista_dotorcamentarias;
    }

    public static function dotacao($dotacao_id){
        $dotacao = DotOrcamentaria::where('id','=',$dotacao_id)->get();
        return $dotacao;
    }

}
