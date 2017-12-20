<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    const ROLE_ADMIN = 1;
    const ROLE_RESPONSAVEL = 2;
    const ROLE_ATENDENTE = 3;
    const ROLE_SUPORTE = 4;
    const ROLE_AT_TEMPORARIO = 5;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_nome', 'email', 'password', 'role', 'role_name', 'exibir', 'avatar', 'role_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
