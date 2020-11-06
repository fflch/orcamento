<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicOrcamentaria extends Model
{
    use HasFactory;
    protected $fillable = ['descricao','observacao','data', 'empenho','debito','credito'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movimento(){
        return $this->belongsTo(Movimento::class);
    }

    public function dotacao(){
        return $this->belongsTo(DotOrcamentaria::class);
    }
}
