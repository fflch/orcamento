<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DotOrcamentaria extends Model
{
    use HasFactory;
    protected $fillable = ['dotacao','grupo','descricaogrupo','item','descricaoitem','receita'];

}
