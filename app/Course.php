<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Course extends Model
{

    use Searchable;


    protected $fillable = [
      'name',
      'description',
      'author'
    ];
}
