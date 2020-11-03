<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $fillable = ['texto','tipo'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tipoconta(){
        return $this->belongsTo(TipoConta::class);
    }
}
