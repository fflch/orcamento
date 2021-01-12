<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function lista_usuarios(){
        $lista_usuarios = User::all()->sortBy('name');
        return $lista_usuarios;
    }

    public function contas_usuarios()
    {
        return $this->belongsToMany(Conta::class,'contas_usuarios')
                ->using(ContaUsuario::class)
                ->withTimestamps()
                ->withPivot([
                    'created_at'
                ]);
    }
}
