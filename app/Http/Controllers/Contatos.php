<?php

namespace App\Http\Controllers;

use App\Contato;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class Contatos extends Controller
{
    public function index(Request $request){
        //$str = $request->get('str',"");

        $contatos = Contato::all('*');

        return view('contatos.leads.leads');
    }

    // Listando pessoas
    public function listar()
    {
        return DB::table('tb_contatos')->whereNull('aprovado')->whereNull('pos_atendimento')->get();
    }

    public function teste(Request $request){
        //$str = $request->get('str',"");

        /*$contatos = Contato::all('*');
        $lead = DB::table('tb_contatos')->whereNull('aprovado')->whereNull('pos_atendimento');
*/
        $lead = DB::table('tb_contatos')
            ->whereNull('aprovado')
            ->whereNull('pos_atendimento')
            ->join('tb_atendimento','id','=','at_id_contato')
            ->paginate(10);

        return view('contatos.leads.teste', ['contatos' => $lead]);
    }
}
