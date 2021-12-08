<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function conta(){
        return $this->hasMany('App\Models\Conta');
    }

    public static function lista_areas(){
        $lista_areas = Area::all()->sortBy('nome');
        return $lista_areas;
    }
}
