<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Comissoes extends Model
{
    use Searchable;

    protected $table = 'tb_comissoes';

    protected $fillable = [

    ];
}
