<?php

namespace App\Http\Controllers;

use App\Brindes;
use App\Contatos;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $status;

    public function index()
    {
        return response()->redirectToRoute('admin.leads');
    }
    public function form(){
        return view('home.infusion');
    }

    public function call(Request $request){


        if($request->input('ligar')){
            $contatos = new Contatos;
            $contatos->data_de_venda = date('d/m/Y H:i:s');
            $contatos->nome_do_produto = 'Pompoarismo Cátia Damasceno';
            $contatos->email = $request->input('email');
            $contatos->nome = $request->input('nome');
            $contatos->ddd = $request->input('ddd');
            $contatos->telefone = $request->input('telefone');
            $contatos->insercao_hotmart = 'Call';
            $contatos->prioridade = 'Solicitou Ligação Agendada';
            $contatos->id_responsavel = 0;


            $data = $request->input('data');
            $hora = $request->input('ligarDepois-hora');

            $date = new \DateTime($data);
            $time = new \DateTime($hora);
            $merge = new \DateTime($date->format('Y-m-d') . ' ' . $time->format('H:i:s'));
            $dataFinal = $merge->format('d/m/Y H:i:s');

            $contatos->observacao = $request->input('solicitar'). "Solicitou ligação para dia e hora: ".$dataFinal;

            $contatos->data_ligar_depois = $dataFinal;
            $contatos->save();

            return redirect('http://lp.toquefeminino.com.br/call-pp-obrigado/');
        }

    }

    public function infusion(Request $request)
    {
        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);
        $all['telefone'] = substr($all['telefone'], 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_custom_CPF');
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
        $all['id_responsavel'] = 10; //Sistema
        $all['pos_atendimento'] = 'Vendido';
        $all['insercao_hotmart'] = 'Página Externa LMBR';
        $all['prioridade']= 'Duvidas profundas sobre o curso';
        $all['enviar_kit'] = 1;
        $all['conferencia'] = 2;

        Brindes::create($all);

    }

    public function wb_brinde(Request $request)
    {
        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);
        $all['telefone'] = substr($all['telefone'], 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_custom_CPF');
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
        $all['id_responsavel'] = 10; //Sistema
        $all['pos_atendimento'] = 'Vendido';
        $all['insercao_hotmart'] = 'Add Brinde Webnário';
        $all['prioridade']= 'Duvidas profundas sobre o curso';
        $all['enviar_kit'] = 1;
        $all['conferencia'] = 2;

        Brindes::create($all);

    }

    public function brinde_pp(Request $request)
    {
        $all['telefone'] = str_replace(" ", "", $request->input('inf_custom_DDDTelefone'));
        $all['telefone'] = str_replace("(", "", $all['telefone']);
        $all['telefone'] = str_replace(")", "", $all['telefone']);

        $ddd = substr($all['telefone'], 0, 2);
        $all['telefone'] = substr($all['telefone'], 2);

        $all['nome'] = $request->input('inf_field_FirstName');
        $all['email'] = $request->input('inf_field_Email');
        $all['documento_usuario'] = $request->input('inf_custom_CPF');
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
        $all['id_responsavel'] = 10; //Sistema
        $all['pos_atendimento'] = 'Vendido';
        $all['insercao_hotmart'] = 'Página Externa';
        $all['prioridade']= 'Duvidas profundas sobre o curso';
        $all['enviar_kit'] = 1;
        $all['conferencia'] = 2;

        Brindes::create($all);

    }

    public function hotmart(Request $request){



        function getWcHotmartStatus($Status = null)
        {
            $HotmartStatus = [
                'started' => 'Iniciado',
                'billet_printed' => 'Boleto Impresso',
                'pending_analysis' => 'Pendente',
                'delayed' => 'Atrasado',
                'canceled' => 'Cancelado',
                'approved' => 'Aprovado',
                'completed' => 'Concluído',
                'chargeback' => 'Chargeback',
                'blocked' => 'Bloqueado',
                'refunded' => 'Devolvido',
                'admin_free' => 'Cadastrado'
            ];
            if (!empty($Status)):
                return $HotmartStatus[$Status];
            else:
                return $HotmartStatus;
            endif;
        }

        header("access-control-allow-origin: https://app-vlc.hotmart.com");
        header('Content-Type: text/html; charset=UTF-8');

        //GET HOTMART POST
        $HotmartSale = $request->all();

        //LOG GENERATE
        if (1 && !empty($HotmartSale)):
            $HotmartLog = null;
            #Criando arquivo pra fazer as paradas, PAREI AQUI DA ULTIMA
            $HotmartAtt = fopen(public_path().'/uploads/hotmart-att.txt', 'a');

            #Regra do banco
            $email = $request->input('email');
            $produto = $request->input('prod_name');
            $pegaEmail = DB::table('tb_contatos')
                ->selectRaw("id, email")
                ->where('email','=', $email)
                ->get();

            $retorno = $pegaEmail->count();


            #Atualizar recebendo o status do HOTMART
            $status = $request->input('status');

            switch($status){
                case 'approved':
                    $status = 'Aprovado';
                    $aprovado = 1;
                    break;

                case 'billet_printed':
                    $status = 'Boleto Impresso';
                    break;

                case 'pending_analysis':
                    $status = 'Pendente';
                    break;

                case 'delayed':
                    $status = 'Atrasado';
                    break;

                case 'canceled':
                    $status = 'Cancelado';
                    break;

                case 'completed':
                    $status = 'Concluído';
                    break;

                case 'chargeback':
                    $status = 'Chargeback';
                    break;

                case 'blocked':
                    $status = 'Bloqueado';
                    break;

                case 'refunded':
                    $status = 'Devolvido';
                    break;

                case 'admin_free':
                    $status = 'Cadastrado';
                    break;
            }

            if($retorno == 1){

                #Se status for aprovado e o produto ser o produto que chegou no post
                if($aprovado == 1){

                    #Aqui na hora atualizar botar conferencia = 1
                    #QUANDO FOR ATUALIZAR< VER SE ENVIAR-KIT = 1
                    $dado = ['status' => $status, 'aprovado' => 1, 'conferencia' => 1, 'conferencia_brinde' => 1];

                }else{
                    $dado = ['status' => $status];
                }

                #Se já existir um aprovado, não substituir o status para outro em hipotese nenhuma

                $upd = DB::table('tb_contatos')
                    ->whereRaw("email = '{$email}'")
                    ->update($dado);
            }else{
                #Tentativa de criar novo contato
                $contatos = new Contatos;
                $contatos->nome_do_produto = $request->input('prod_name');
                $contatos->nome_do_produtor = $request->input('producer_name');
                $contatos->documento_produtor = $request->input('producer_document');
                $contatos->nome = $request->input('name');
                $contatos->ddd = $request->input('phone_local_code');
                $contatos->telefone = $request->input('phone_number');
                $contatos->documento_usuario = $request->input('doc');
                $contatos->transacao = $request->input('transaction');
                $contatos->email = $request->input('email');
                $contatos->status = $status;
                $contatos->insercao_hotmart = 'Hotmart';
                $contatos->prioridade = 'Oportunidade Hotmart';
                $contatos->data_de_venda = $request->input('purchase_date');
                $contatos->id_responsavel = 0;

                $contatos->save();

                #$dados =  $request->all();
                #Se retornar zero precisa criar um novo registro.
                $HotmartLogFile = fopen(public_path().'/uploads/n-existe.txt', 'a');


            }

            foreach ($HotmartSale as $key => $value):

                if($key == 'status' || $key == 'email' || $key == 'doc' || $key == 'name'){
                    $HotmartLog .= "{$key}: {$value}\r\n";
                }

            endforeach;


            fwrite($HotmartAtt, $HotmartLog);
            fclose($HotmartAtt);

            $HotmartLogFile = fopen(public_path().'/uploads/hotmart.txt', 'a');
            fwrite($HotmartLogFile, "\r\n########## " . date('d/m/Y H\hi') . " ##########\r\n\r\n" . $HotmartLog);
            fclose($HotmartLogFile);
        endif;

        $queryProd = DB::table('tb_produtos')
            ->select('*')
            ->where('prod_id', '=', 3)
            ->get();

        foreach($queryProd as $p):
            $apiChave = $p->api_chave;
        endforeach;

        if ($HotmartSale && !empty($request->input('hottok')) && $request->input('hottok') == 'qv82T5NcQDBW4lR8Yi4vkD5eAmTuYY123249'):
            //CLEAR DATA
            array_map('strip_tags', $HotmartSale);
            array_map('trim', $HotmartSale);
            array_map('rtrim', $HotmartSale);

            //GET HOTMART TRANSACTION
            $HotmartTransaction = (!empty($request->input('transaction_ext')) ? $request->input('transaction_ext') : $request->input('transaction'));

            //PRODUCT NEGATIVATE
            if (!empty('hotmartnegativeID')):
                $NegativateProductsExmplode = explode(',', 'hotmartnegativeID');
                $NegativateProductsTrim = array_map('trim', $NegativateProductsExmplode);
                $NegativateProducts = array_map('rtrim', $NegativateProductsTrim);

                if (in_array($request->input('prod'), $NegativateProducts)):
                    exit;
                endif;
            endif;
        endif;

    }

    public function form_hotmart(){
        return view('formpost');
    }
}
