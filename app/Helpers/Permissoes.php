<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;

class Permissoes
{
    protected $nivel = array();

    public function validarPermissao(array $nivel)
    {
        $this->nivel = $nivel;
        if(isset(Auth::user()->role)){
            if(!in_array(Auth::user()->role, $this->nivel)){
                redirect('/admin/dashboard/');
            }
        }
        return $this;
    }
}
