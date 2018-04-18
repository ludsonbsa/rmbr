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

        $param =
              $request->input('inf_field_FirstName').'\n'
            . $request->input('inf_field_Email').'\n'
            . $request->input('inf_field_SSN').'\n'
            . $request->input('inf_custom_DDDTelefone').'\n'
            . $request->input('inf_custom_EstadoSigla').'\n'
              . $request->input('inf_field_Address2Street1').'\n'
              . $request->input('inf_field_Address2Street2').'\n'
              . $request->input('inf_field_City2').'\n'
              . $request->input('inf_field_PostalCode2').'\n'
              . $request->input('inf_custom_Numero').'\n'
              . $request->input('inf_custom_Complemento');

        $caminho = public_path().'/uploads/planilhas/teste.txt';
        $fp = fopen($caminho, "a");

        // Escreve "exemplo de escrita" no bloco1.txt
        $escreve = fwrite($fp, $param);

        // Fecha o arquivo
        fclose($fp);



    }
}
