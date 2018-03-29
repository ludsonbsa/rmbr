<?php

namespace App\Http\Controllers;

use App\Brindes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrindesController extends Controller
{

    public function index()
    {
        $brindes = DB::table('tb_contatos as t1')
        ->selectRaw('t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome')
            ->join('users as t2', 't1.id_responsavel', '=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 0 AND t1.enviar_kit = 1) AND (t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 'Vendido')")
            ->groupBy('t1.email')
            ->orderBy('t1.id', 'ASC')
            ->paginate(25);

        return view('brindes.listar', ['brindes' => $brindes]);
    }


    public function cadastrar(Request $request)
    {
        if(Brindes::create($request->all())){
            $msg = '<div class="alert alert-success"><strong>Brinde</strong> cadastrado com sucesso</div>';
        }else{
            $msg = '<div class="alert alert-danger"><strong>Brinde</strong> não cadastrado</div>';
        }
        return response()->redirectToRoute('admin.brindes.add')->with('message',$msg);
    }

    public function resultado_conferencia(){
        //listagem das comissões a serem conferidas
        $queryBrindesNAP = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->get();

        $countNAP = $queryBrindesNAP->count();

        $queryBrindesAP = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado = 1 AND etiqueta_gerada IS NULL)  AND (t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 'Vendido')")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->get();
        $countBAP = $queryBrindesAP->count();

        return view('brindes.resultados-conferencia', ['aprovados' => $countBAP, 'nao_aprovados' => $countNAP]);
    }

    public function aprovar_manualmente(){

        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome_do_produto, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();

        $count = $query->count();
        return view('brindes.aprovar-manualmente', ['brindes' => $query, 'contagem' => $count]);

    }

    public function gerar_etiquetas()
    {
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.nome_do_produto, t1.data_de_venda, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome, t2.id")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND (t1.etiqueta_gerada IS NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.data_de_venda','ASC')
            ->get();
        $count = $query->count();

        return view('brindes.gerar-etiquetas', ['contatos' => $query, 'contagem' => $count]);

    }



    public function baixar_etiquetas()
    {
        return view('brindes.baixar-etiquetas');
    }

}
