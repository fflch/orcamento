<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero',
        'nome',
        'departamento',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
