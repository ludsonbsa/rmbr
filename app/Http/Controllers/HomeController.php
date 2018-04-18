<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return response()->redirectToRoute('admin.leads');
    }
    public function form(){
        return view('home.infusion');
    }

    public function infusion(Request $request)
    {

        if($request['inf_field_FirstName']){
            $caminho = public_path().'/uploads/planilhas/teste.txt';
            $fp = fopen($caminho, "a");

            // Escreve "exemplo de escrita" no bloco1.txt
            $escreve = fwrite($fp, $request['inf_field_FirstName']);

            // Fecha o arquivo
            fclose($fp);
        }


    }
}
