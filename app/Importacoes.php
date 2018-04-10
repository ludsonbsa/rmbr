<?php

namespace App;

use App\Events\PlanilhaImportada;
use Illuminate\Database\Eloquent\Model;

class Importacoes extends Model
{
    protected $events = [
      'created' => PlanilhaImportada::class
    ];
}
