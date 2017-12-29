<?php

namespace App\Http\Controllers;

use App\Contatos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Notifications\NotifyContato;

class ContatosController extends Controller
{
    public function index(Request $request){
        $lead = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id,  t1.data_de_venda, t1.nome, t1.ddd, t1.telefone, t1.email, t1.obs_followup, t1.observacao, t1.status, t1.documento_usuario, t1.em_atendimento, t1.insercao_hotmart, t1.prioridade, t1.id_responsavel, t2.user_nome")
            ->join('users as t2','t2.id','=','t1.id_responsavel')
            ->whereRaw("(t1.aprovado IS NULL AND t1.pos_atendimento IS NULL)")
            ->whereRaw("(t1.status != 'Boleto Impresso' AND t1.status != 'Expirado')")
            ->groupBy('t1.email')
            ->orderBy('t1.email','DESC')
            ->paginate();
            //VEr poque quando vc adiciona o lead em adicionar, ele não tá caindo na condição aqui de cima
        return view('contatos.leads.leads', ['contatos' => $lead]);
    }

    public function find($id)
    {

        $query = DB::table('tb_contatos')
            ->selectRaw("tb_contatos.id, tb_contatos.nome_do_produto, tb_contatos.data_de_venda, tb_contatos.nome, tb_contatos.ddd, tb_contatos.telefone, tb_contatos.email, tb_contatos.obs_followup, tb_contatos.observacao, tb_contatos.status, tb_contatos.documento_usuario, tb_contatos.em_atendimento, tb_contatos.insercao_hotmart, tb_contatos.prioridade, tb_contatos.id_responsavel, t2.user_nome")
            ->join('users as t2','tb_contatos.id_responsavel','=','t2.id')
            ->where('tb_contatos.id','=', $id)
            ->get();
        return view('contatos.leads.editar', ['contato' => $query]);
    }

    public function atender($id)
    {
        $query = DB::table('tb_contatos')
            ->selectRaw("tb_contatos.id, tb_contatos.nome_do_produto, tb_contatos.data_de_venda, tb_contatos.nome, tb_contatos.ddd, tb_contatos.telefone, tb_contatos.email, tb_contatos.obs_followup, tb_contatos.observacao, tb_contatos.status, tb_contatos.documento_usuario, tb_contatos.em_atendimento, tb_contatos.insercao_hotmart, tb_contatos.prioridade, tb_contatos.id_responsavel, t2.user_nome")
            ->join('users as t2','tb_contatos.id_responsavel','=','t2.id')
            ->where('tb_contatos.id','=', $id)
            ->get();
        return view('contatos.leads.atender', ['contato' => $query]);
    }

    public function teste(){
        /*$lead = DB::table('tb_contatos')
            ->selectRaw("tb_contatos.id,  tb_contatos.data_de_venda, tb_contatos.nome, tb_contatos.ddd, tb_contatos.telefone, tb_contatos.email, tb_contatos.obs_followup, tb_contatos.observacao, tb_contatos.status, tb_contatos.documento_usuario, tb_contatos.em_atendimento, tb_contatos.insercao_hotmart, tb_contatos.prioridade, tb_contatos.id_responsavel, t2.user_nome")
            ->groupBy('tb_contatos.email')
            ->join('users as t2','tb_contatos.id_responsavel','=','t2.id')
            ->whereRaw("(tb_contatos.aprovado IS NULL AND tb_contatos.pos_atendimento IS NULL)")
            ->whereRaw("(tb_contatos.status != 'Boleto Impresso' AND tb_contatos.status !=
'Expirado')")
            ->paginate(15);*/

        return view('courses.angular');
    }

    public function update(Request $request, $id){

    }

    public function deletar(Request $request, $id){
        //Remove
        if(Contatos::destroy($id)){
            $msg = '<div class="alert alert-success"><strong>Lead</strong> apagado com sucesso</div>';
        }else{
            $msg = '<div class="alert alert-danger"><strong>Lead</strong> não apagado</div>';
        }

        return response()->redirectToRoute('admin.leads')->with('message',$msg);
    }

    public function add(){
        return view('contatos.leads.add');
    }

    public function cadastrar(Request $request){
        if(Contatos::create($request->all())){
            $msg = '<div class="alert alert-success"><strong>Lead</strong> cadastrado com sucesso</div>';
        }else{
            $msg = '<div class="alert alert-danger"><strong>Lead</strong> não cadastrado</div>';
        }

        return response()->redirectToRoute('admin.lead.add')->with('message',$msg);

    }
}
