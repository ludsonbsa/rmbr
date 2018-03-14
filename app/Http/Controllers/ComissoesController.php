<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Comissoes;

class ComissoesController extends Controller
{

    public function conferencia()
    {
        //listagem das comissões a serem conferidas
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.pos_atendimento ='Boleto Gerado' OR t1.pos_atendimento = 
'Vendido') AND (t1.insercao_hotmart != 'Pagina Externa') AND t1.conferencia = 0")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->paginate(25);

        $count = $query->count();

        return view('comissoes.listar', ['contatos' => $query, 'count' => $count]);
    }


    public function conferidas()
    {
        //listagem das comissões a serem conferidas
        $queryAPROVADAS = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND (t1.comissao_gerada IS NULL) AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12'")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->get();

        $count = $queryAPROVADAS->count();

        $queryNAOAPROVADAS = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND t2.id != 10 AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12'")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')->get();

        $count2 = $queryNAOAPROVADAS->count();

        return view('comissoes.conferidas', ['aprovadas' => $count, 'nao_aprovadas' => $count2]);
    }

    public function conferir(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 
'Vendido') AND (t1.insercao_hotmart != 'Pagina Externa') AND t1.conferencia = 0")
            ->orderBy('t1.id','ASC')->get();

        foreach($query as $resultado){
            $cpf = $resultado->documento_usuario;
            $email = $resultado->email;
            $telefone = $resultado->telefone;

            #Verifico resultados começando por CPF
            if ($cpf) {
                #Digo qual é a query que ele vai fazer, é por cpf e aprovado
                $query = "documento_usuario";
                $like = $cpf;

                $dados = [
                    'conferencia' => 1
                ];

                $upd = DB::table('tb_contatos')
                    ->where('documento_usuario', $cpf)
                    ->update($dados);

            #Se não tiver CPF, e existir e-mail, então faz update para todos como aquele e-mail
            }elseif(empty($cpf) && !empty($email)) {
                #Digo qual é a query que ele vai fazer, é por email e aprovado
                $query = "email";
                $like = $email;

                $dados = [
                    'conferencia' => 1
                ];

                $upd = DB::table('tb_contatos')
                    ->where('email', $email)
                    ->update($dados);

            #Se não tiver CPF, e e nem e-mail, então faz update para todos como telefone
            }elseif (empty($email) && empty($cpf)) {
                #Digo qual é a query que ele vai fazer, é por telefone e aprovado
                $query = "telefone";
                $like = $telefone;

                $dados = [
                    'conferencia' => 1
                ];
                $upd = DB::table('tb_contatos')
                    ->where('telefone', $telefone)
                    ->update($dados);
            }

            $queryString = DB::table('tb_contatos')
                ->selectRaw("email, documento_usuario, telefone")
                ->whereRaw("{$query} LIKE '%{$like}%' AND status = 'aprovado'")
                ->get();

            #Fiz um select com a query do caso acima, apenas para ver em tela os dados
        }
        return response()->redirectToRoute('admin.comissoes.listar')->with('message',"teste");
    }

    public function aprovar_manualmente(){

        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();

        $count = $query->count();

        return view('comissoes.aprovar-manualmente', ['contatos' => $query, 'contagem' => $count]);
    }

    public function aprovar($id){
        $dados = [ 'aprovado' => 1 ];
        $update = DB::table('tb_contatos')
            ->where('id', $id)
            ->update($dados);
        return $id;
    }

    public function reprovar($id){
        $dados = [ 'aprovado' => 0 ];
        $update = DB::table('tb_contatos')
            ->where('id', $id)
            ->update($dados);
        return $id;
    }

    public function comissionar_pendentes(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome, t2.id")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != 
            NULL) AND (t1.comissao_gerada IS NULL AND insercao_hotmart != 'Pagina Externa' AND insercao_hotmart != 'Pagina Externa WB 15-12')")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();
        $count = $query->count();
        return view('comissoes.comissionar-pendentes', ['contatos' => $query, 'contagem' => $count]);
    }


}
