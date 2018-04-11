<?php

namespace App\Http\Controllers;

use App\Brindes;
use App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BrindesController extends Controller
{

    public function index()
    {
        $brindes = DB::table('tb_contatos as t1')
        ->selectRaw('t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.ddd, t1.insercao_hotmart, t2.user_nome')
            ->join('users as t2', 't1.id_responsavel', '=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 0 AND t1.enviar_kit = 1) AND (t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 'Vendido')")
            ->groupBy('t1.email')
            ->orderBy('t1.id', 'ASC')
            ->paginate(25);

        return view('brindes.listar', ['brindes' => $brindes]);
    }

    public function add(){
        return view('brindes.add');
    }

    public function buscar(){
        return view('brindes.buscar');
    }

    public function editar($id){
        $brindes = DB::table('tb_contatos as t1')
            ->selectRaw('t1.id, t1.documento_usuario, t1.endereco, t1.cep, t1.numero, t1.complemento, t1.bairro, t1.cidade, t1.cidade, 
t1.estado, t1.nome_do_produto, t1
            .nome, t1
            .email, t1
            .telefone, t1.ddd, t1
            .insercao_hotmart')
            ->where('t1.id','=', $id)->get();
        return view('brindes.editar', ['brindes' => $brindes]);
    }

    public function editar_update(Request $request, $id){
        #Update na tabela contatos com as informações
        $param = $request->all();
        $param['data_de_venda'] = date('d/m/Y H:i:s');
        $param['em_atendimento'] = NULL;
        $param['pais'] = 'Brasil';
        $param['id_responsavel'] = Auth::id();
        $param['pos_atendimento'] = 'Vendido';
        $param['conferencia'] = 2;

        $param = $request->except('_token','sendForm');
        $brindes = Brindes::where('id', '=', $id);
        $brindes->update($param);

        return response()->redirectToRoute('admin.listar.brindes')->with('msg',"Brinde editado com sucesso");
    }


    public function cadastrar(Request $request)
    {
        $all = $request->all();
        $telefone = $all['telefone'];

        $ddd = substr($telefone, 0, 2);
        $all['ddd'] = $ddd;
        $all['data_de_venda'] = date('d/m/Y H:i:s');
        $all['em_atendimento'] = NULL;
        $all['pais'] = 'Brasil';
        $all['id_responsavel'] = Auth::id();
        $all['pos_atendimento'] = 'Vendido';
        $all['conferencia'] = 2;

        if(Brindes::create($all)){
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

    public function criar_etiquetas(){

          $query = DB::table('tb_contatos as t1')
              ->selectRaw("t1.id, t1.documento_usuario, t1.endereco, t1.cep, t1.numero, t1.complemento, t1.bairro, t1.cidade, t1.cidade, t1.estado, t1.nome_do_produto, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome")
              ->join('users as t2','t1.id_responsavel','=','t2.id')
              ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND t1.etiqueta_gerada IS NULL AND t1.endereco IS NOT NULL AND t1.endereco != ''")
              ->groupBy('t1.email')
              ->orderBy('t1.id','DESC')
              ->get();

        $csv = new Helpers\CSV();
        $csv->addLine(new Helpers\CSVLine('nome', 'cep', 'endereco', 'numero', 'complemento', 'bairro', 'cidade', 'estado', 'servico', 'email'));

        //Adicionar linhas do banco de dados no arquivo CSV
        foreach ($query as $etiqueta):

            $cep = explode('.', $etiqueta->cep);
            $cep = implode('', $cep);

            $nome = $etiqueta->nome;

            $csv->addLine(new Helpers\CSVLine($nome, $cep, $etiqueta->endereco, $etiqueta->numero, $etiqueta->complemento, $etiqueta->bairro, $etiqueta->cidade, $etiqueta->estado, 'PAC', $etiqueta->email));

            $email = $etiqueta->email;
            #Faz o update
            $dados = [
                'etiqueta_gerada' => 1,
                'data_etiqueta' => date('Y-m-d H:i'),
                'completo' => 2
            ];
            #Faz update nos emails relacionados
            $update = DB::table('tb_contatos')
                ->where('email', 'LIKE', $email)
                ->update($dados);

        endforeach;

        $csv->save("uploads/etiquetas/etiqueta_" . date('d-m-Y H-i').".csv");

        return response()->redirectToRoute('admin.listar.brindes');

    }

    public function aprovar_manualmente_pdf(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome_do_produto, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart,t1.ddd, t1.endereco, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado IS NULL) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.id','ASC')
            ->get();

        #Cria o PDF
        $pdf = new \FPDF("P","pt","A4");
        $pdf->AddPage();
        $pdf->SetFont('arial','B',12);
        $pdf->Cell(0,15,'etiquetas Pendentes',0,1,'L');
        $pdf->Ln();

        foreach ($query as $dados){
            $endereco = $dados->endereco;
            if(empty($endereco) || $endereco == ''){
                $endereco = "Não possui endereço";
            }

            $pdf->Ln();
            $pdf->Cell(0,15,date('d/m/Y H:i:s'),0,1,'L');
            $pdf->Cell(0,20,$dados->nome,0,1,'L');
            $pdf->Cell(0,15,"Telefone: ".$dados->telefone,0,1,'L');
            $pdf->Cell(0,15,"Produto: ".$dados->nome_do_produto,0,1,'L');
            $pdf->Cell(0,15,"E-mail: ".$dados->email,0,1,'L');
            $pdf->Cell(0,15,"CPF: ".$dados->documento_usuario,0,1,'L');
            $pdf->Cell(0,15,"Endereço: ".$endereco,0,1,'L');
            $pdf->Ln();
        }

        $pdf->Ln(8);
        $pdf->Output("aprovar-brindes-manual-".date('d-m-Y').".pdf","D");
    }

    public function gerar_etiquetas()
    {
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.nome_do_produto, t1.data_de_venda, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.endereco, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND (t1.etiqueta_gerada IS NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.data_de_venda','ASC')
            ->get();
        $count = $query->count();

        return view('brindes.gerar-etiquetas', ['contatos' => $query, 'contagem' => $count]);
    }

    public function gerarpdf_pendentes(){
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.nome_do_produto, t1.data_de_venda, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.endereco, t2.user_nome, t2.id")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 1 AND t1.aprovado = 1) AND (t1.pos_atendimento != 1 OR t1.pos_atendimento != NULL) AND (t1.etiqueta_gerada IS NULL)")
            ->groupBy('t1.email')
            ->orderBy('t1.data_de_venda','ASC')
            ->get();

        #Cria o PDF
        $pdf = new \FPDF("P","pt","A4");
        $pdf->AddPage();
        $pdf->SetFont('arial','B',12);
        $pdf->Cell(0,15,'etiquetas Pendentes',0,1,'L');
        $pdf->Ln();

        foreach ($query as $dados){
            $endereco = $dados->endereco;
            if(empty($endereco) || $endereco == ''){
                $endereco = "Nao possui endereco";
            }
            $pdf->Ln();
            $pdf->Cell(0,15,date('d/m/Y H:i:s'),0,1,'L');

            $pdf->Cell(0,15,$dados->nome,0,1,'L');
            $pdf->Cell(0,15,"Telefone: ".$dados->telefone,0,1,'L');
            $pdf->Cell(0,15,"Produto: ".$dados->nome_do_produto,0,1,'L');
            $pdf->Cell(0,15,"E-mail: ".$dados->email,0,1,'L');
            $pdf->Cell(0,15,"CPF: ".$dados->documento_usuario,0,1,'L');
            $pdf->Cell(0,15,"Endereco: ".$endereco,0,1,'L');
            $pdf->Ln();
        }

        $pdf->Ln(8);
        $pdf->Output("etiquetas-pendentes-".date('d-m-Y').".pdf","D");
    }

    public function conferirBrindes(){
        $brindes = DB::table('tb_contatos as t1')
            ->selectRaw('t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.ddd, t1.insercao_hotmart, t2.user_nome')
            ->join('users as t2', 't1.id_responsavel', '=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 0 AND t1.enviar_kit = 1) AND (t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 'Vendido')")
            ->groupBy('t1.email')
            ->orderBy('t1.id', 'ASC')
            ->get();

        foreach($brindes as $resultado) {
            $cpf = $resultado->documento_usuario;
            $email = $resultado->email;
            $telefone = $resultado->telefone;

            #Verifico resultados começando por CPF
            if ($cpf) {
                #Digo qual é a query que ele vai fazer, é por cpf e aprovado
                $query = "documento_usuario";
                $like = $cpf;

                $dados = [
                    'conferencia_brinde' => 1
                ];

                $upd = DB::table('tb_contatos')
                    ->where('documento_usuario', $cpf)
                    ->update($dados);

                #Se não tiver CPF, e existir e-mail, então faz update para todos como aquele e-mail
            } elseif (empty($cpf) && !empty($email)) {
                #Digo qual é a query que ele vai fazer, é por email e aprovado
                $query = "email";
                $like = $email;

                $dados = [
                    'conferencia_brinde' => 1
                ];

                $upd = DB::table('tb_contatos')
                    ->where('email', $email)
                    ->update($dados);

                #Se não tiver CPF, e e nem e-mail, então faz update para todos como telefone
            } elseif (empty($email) && empty($cpf)) {
                #Digo qual é a query que ele vai fazer, é por telefone e aprovado
                $query = "telefone";
                $like = $telefone;

                $dados = [
                    'conferencia_brinde' => 1
                ];
                $upd = DB::table('tb_contatos')
                    ->where('telefone', $telefone)
                    ->update($dados);
            }

        }

        return response()->redirectToRoute('admin.listar.brindes');
    }

    public function aprovar($id){
                $dados = [ 'aprovado' => 1 ];

                DB::table('tb_contatos')
                    ->where('id', $id)
                    ->update($dados);
                $return = $id;

        return $return;
    }

    public function reprovar($id){
                $dados = [ 'aprovado' => 0 ];
                DB::table('tb_contatos')
                    ->where('id', $id)
                    ->update($dados);
                $return = $id;

        return $return;
    }

    public function etiquetaRelatorioPendente(){

    }

    public function deletar_etiqueta($etiqueta){
        $dir = public_path().'/uploads/etiquetas/';
        unlink($dir . $etiqueta);
        return response()->redirectToRoute('admin.listar.brindes')->with('msg',"Etiqueta deletada com sucesso!");
    }

    public function baixar($etiqueta){
        $dir = public_path().'/uploads/etiquetas/';

        $args = array(
            'download_path' => $dir,
            'file' => $etiqueta,
            'extension_check' => TRUE,
            'referrer_check' => FALSE,
            'referrer' => NULL,
        );

        $download = new Helpers\Download($args);
        $download_hook = $download->get_download_hook();

        if ($download_hook['download'] == TRUE) {
            $download->get_download();
        }
    }

    public function baixar_etiquetas()
    {
        $dir = public_path().'/uploads/etiquetas/';
        $scan = scandir($dir,1);
        $contatosEt = $scan;

        return view('brindes.baixar-etiquetas', ['scan' => $contatosEt]);
    }


}
