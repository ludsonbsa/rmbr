<?php

namespace App\Http\Controllers;

use App\Importacoes;
use Illuminate\Http\Request;

class ImportacoesController extends Controller
{

    public function index()
    {
        return view('contatos.importar');
    }


}
