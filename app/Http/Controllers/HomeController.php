<?php

namespace App\Http\Controllers;

use App\Brindes;
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
                $request->input('inf_field_FirstName')."\n"
              . $request->input('inf_field_Email')."\n"
              . $request->input('inf_custom_CPF')."\n"
              . $request->input('inf_custom_DDDTelefone')."\n"
              . $request->input('inf_custom_EstadoSigla')."\n"
              . $request->input('inf_field_Address2Street1')."\n"
              . $request->input('inf_field_Address2Street2')."\n"
              . $request->input('inf_field_City2')."\n"
              . $request->input('inf_field_PostalCode2')."\n"
              . $request->input('inf_custom_Número')."\n"
              . $request->input('inf_custom_Complemento');



        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_field_SSN');
        $all['estado'] = $request->input('inf_custom_EstadoSigla');
        $all['cidade'] = $request->input('inf_field_City2');
        $all['cep'] = $request->input('inf_field_PostalCode2');
        $all['endereco'] = $request->input('inf_field_Address2Street1');
        $all['bairro'] = $request->input('inf_field_Address2Street2');
        $all['numero'] = $request->input('inf_custom_Numero');
        $all['complemento'] = $request->input('inf_custom_Complemento');
        $all['ddd'] = $ddd;
        $all['data_de_venda'] = date('d/m/Y H:i:s');
        $all['em_atendimento'] = NULL;
        $all['pais'] = 'Brasil';
        $all['id_responsavel'] = Auth::id();
        $all['pos_atendimento'] = 'Vendido';
        $all['enviar_kit'] = 1;


        $caminho = public_path().'/uploads/planilhas/teste.txt';
        $fp = fopen($caminho, "a");

        // Escreve "exemplo de escrita" no bloco1.txt
        $escreve = fwrite($fp, $param);

        // Fecha o arquivo
        fclose($fp);

        /*
        if(Brindes::create($all)){
            $msg = '<div class="alert alert-success"><strong>Brinde</strong> cadastrado com sucesso</div>';
        }else{
            $msg = '<div class="alert alert-danger"><strong>Brinde</strong> não cadastrado</div>';
        }
       */

    }
}
