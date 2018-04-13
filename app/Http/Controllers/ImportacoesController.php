<?php

namespace App\Http\Controllers;

use App\Console\Commands\Arquivo;
use App\Jobs\ImportarPlanilha;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use App\Helpers;



class ImportacoesController extends Controller implements ShouldQueue
{
    use InteractsWithQueue;

    public $arquivo;

    public function index()
    {
        return view('contatos.importar');
    }

    public function recuperacao()
    {
        return view('contatos.recuperacao');
    }

    public function setArquivo($arquivo){
        return $this->arquivo = $arquivo;
    }

    public function getArquivo(){

       return $this->arquivo;
    }

    public function planilhaImport()
    {

        if (Input::hasFile('planilha')){
            //Se não existir pasta de planilhas
            $logicpath = public_path() . '/uploads/planilhas';
            if (!is_dir($logicpath)) {
                mkdir($logicpath, 0777, true);
            }
            //Move planilha pra pasta de planilhas
            $file = Input::file('planilha');
            $fileExtension = $file->getClientOriginalExtension();

            //Verifica se o arquivo é CSV.
            if ($fileExtension == 'csv') {

                //Faz upload antes da importação
                #Seria bom pegar o nome do arquivo, mudar para um padrão sempre.
                $filename = $file->getClientOriginalName();

                $file->move($logicpath, $file->getClientOriginalName());

                # Abrir o arquivo em CSV
                $handle1 = fopen($logicpath . "/" . $file->getClientOriginalName(), 'r');

                $caminho = $logicpath."/".$file->getClientOriginalName();


                #Seto o nome do arquivo e salvo na função
                $this->setArquivo(public_path() ."/uploads/planilhas/" . $file->getClientOriginalName());
                $completo = $this->getArquivo();

                $completo = str_replace('\\','/', $completo);

                dispatch(new ImportarPlanilha(Auth::id(), $completo));
                #dispatchNow(new ImportarPlanilha(Auth::id(), $this->getArquivo()));
                fclose($handle1);

            }
        }

        return back()->with('msg',"Planilha adicionada, estamos verificando e atualizando os dados, aguarde o e-mail de confirmação!");

    }

    /**
     * @param $id //De quem está inserindo
     * @return $this
     * Código totalmente necessário, com ele posso inserir novos registros da tabela HOTMART mesmo se o registro já existir, a coluna de transacao no bando de dados está setado como UNIQUE então nada será replicado, apenas verificar ou acescentado caso não houver.
     */
    public function queryHotmart($id){
        $pdo = DB::connection()->getPdo();
        $query = "LOAD DATA LOCAL INFILE '".$this->getArquivo()."' INTO TABLE tb_contatos CHARACTER SET UTF8 FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES
	    (nome_do_produto, nome_do_produtor, documento_produtor, nome_afiliado, transacao, meio_de_pagamento, origem, moeda_1, preco_do_produto, moeda_2, preco_da_oferta, taxa_de_cambio, moeda_3, preco_original, numero_da_parcela, recorrencia, data_de_venda, data_de_confirmacao, status, nome, documento_usuario, email, ddd, telefone, cep, cidade, estado, bairro, pais, endereco, numero, complemento, chave, codigo_produto, codigo_afiliacao, codigo_oferta, origem_checkout, tipo_de_pagamento, periodo_gratis, coproducao, origem_comissao, preco_total, tipo_pagamento,insercao_hotmart,prioridade, observacao, id_responsavel, conferencia) set insercao_hotmart = 'Hotmart', prioridade = 'Oportunidade Hotmart', id_responsavel = '".$id."', conferencia = 0;";

        $pdo->exec($query);
        return $this;
    }

    public function aprovados(){
        #Adicionar linhas do banco de dados no arquivo CSV
        $executionStartTimeAP = microtime(true);

        $aprovados = DB::select("SELECT nome_do_produto, nome, documento_usuario, status, email, transacao FROM tb_contatos WHERE (status = 'aprovado' OR status = 'completo') AND completo = 0");
        $executionStartTimeAPEND = microtime(true);

        $totalAP = $executionStartTimeAPEND - $executionStartTimeAP;
        \Log::info("SELECT AP - Aprovados e completos: {$totalAP}");

        $csv = new Helpers\CSV();
        #Instanciar gerador CSV*/
        foreach($aprovados as $registro){
            #Adiciona a linha de cada aprovado
            $csv->addLine(new Helpers\CSVLine($registro->nome_do_produto, $registro->nome, $registro->documento_usuario, $registro->status, $registro->email, $registro->transacao));
        }
        $csv->save("uploads/planilhas/aprovados.csv");

        #Problemas : Toda vez ele vai selecionar do banco de dados inteiro pra verificar os aprovados e completos, com um banco de 100 mil registros vai ser foda..
        /* Abre o arquivo de aprovados, para leitura de dados */

        #Abrir o arquivo com os aprovados pra não precisar ler aprovados mais de uma vez
        $handle = fopen('uploads/planilhas/aprovados.csv', "r");

        $cpfs = array();
        $emails = array();

        $executionStartTimeALLAP = microtime(true);
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $cpf = $data[2];
            $email = $data[4];

            $query = "SELECT id ,documento_usuario, email, status
        FROM tb_contatos WHERE documento_usuario LIKE '%{$cpf}%' AND (status = 'Aprovado' OR status = 'completo') AND completo = 0";

            #Se vazio CPF, então busca por e-mail
            if (empty($cpf)) {
                $query = "SELECT id, documento_usuario, email, status
        FROM tb_contatos WHERE email LIKE '%{$email}%' AND (status = 'aprovado' OR status = 'completo') AND completo = 0";
            }
          #Faço uma query PDO para atualizar status aprovado a todos os registros que forem aprovados
            $bus = DB::select($query);

            foreach ($bus as $re):
                //Update de aprovação
                $dad = [
                    'aprovado' => 1
                ];
                //ler se existe, em caso afirmativo faz o update
                    DB::table('tb_contatos')
                        ->where('id', $re->id)
                        ->update($dad);

                #Vai Acrescentando os valores de CPF e email nos arrays.
                array_push($cpfs, $re->documento_usuario);
                array_push($emails, $re->email);
            endforeach;
            /******
             * Fazer uma consulta de CPF dentro dos CPF existentes aprovados, e marcar CAMPO aprovado = 1
             * mesmo para os CPFs com estado cancelados ou expirados porem que já possuam algum status aprovado ou completo.
             *****/
            foreach ($cpfs as $indice => $valor):
                if (!empty($valor)) {
                    $updateS = ['aprovado' => 1];
                    try {
                        DB::table('tb_contatos')
                            ->where('documento_usuario', $valor)
                            ->update($updateS);
                    } catch (\PDOException $e) {
                        return $e->getCode() . $e->getMessage();
                    }
                }
            endforeach;

            foreach ($emails as $indice => $valor):
                if (!empty($valor)) {
                    $updateS = ['aprovado' => 1];
                    try {
                        DB::table('tb_contatos')
                            ->where('email', $valor)
                            ->update($updateS);
                    } catch (\PDOException $e) {
                        return $e->getCode() . $e->getMessage();
                    }
                }
            endforeach;

        }
        #Precisa rever isso aqui, tá muito pesado os dados
        /**/

        $executionStartTimeALLAP2 = microtime(true);
        $totalAP2 =  $executionStartTimeALLAP2 - $executionStartTimeALLAP;
        \Log::info("SELECT AP - Pega os ap com cpf e email: {$totalAP2}");

        return $this;
    }

    public function verificapa(){
        #Função que registra em um CSV Todos os pos_atendimentos EXISTENTES, que ja recebeu atendimento pela atendente.
        #BUSCANDO OS REGISTROS
        $query = "SELECT id, documento_usuario, email, telefone, nome FROM tb_contatos WHERE pos_atendimento IS NOT NULL AND completo = 0";

        try {
            $resultado = DB::select($query);
        } catch (\PDOException $e) {
            return $e->getCode() . " - " . $e->getMessage() . " - " . $e->getLine();
        }

        //Instanciar gerador CSV
        $csv = new Helpers\CSV();

        //Adicionar linhas do banco de dados no arquivo CSV
        foreach ($resultado as $registro):
            $csv
                ->addLine(new Helpers\CSVLine($registro->id, $registro->nome, $registro->documento_usuario, $registro->email, $registro->telefone));
        endforeach;

        return $csv->save("uploads/planilhas/pos_atendimento.csv");
    }

    /*public function atribuirPosAt(){
        #Modificar
        $handle = fopen('uploads/planilhas/pos_atendimento.csv', "r");

        $cpfs = array();
        $emails = array();
        $telefones = array();

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $cpf = $data[2];
            $email = $data[3];
            $telefone = $data[4];

            $bus = "SELECT id, documento_usuario, email, telefone, nome
        FROM tb_contatos
        WHERE documento_usuario LIKE '%{$cpf}%' AND pos_atendimento IS NULL";

            if (empty($cpf)) {
                $bus = "SELECT id, documento_usuario, email, telefone, nome
        FROM tb_contatos
        WHERE email LIKE '%{$email}%' AND pos_atendimento IS NULL";
            }
            if (empty($email)) {
                $bus = "SELECT id, documento_usuario, email, telefone, nome
        FROM tb_contatos
        WHERE telefone = '{$telefone}' AND pos_atendimento IS NULL";
            }

            $this->busca = $bus;

            $result = $bus = DB::select($bus);

            foreach ($result as $re):

                $upd = "UPDATE tb_contatos SET pos_atendimento = 1 WHERE id ={$re->id}";
                $this->pdo->query($upd);

                array_push($cpfs, $re['documento_usuario']);
                array_push($emails, $re['email']);
                array_push($telefones, $re['telefone']);

            endforeach;
        }


        fclose($handle);
    }*/

    public function planilhaRecuperacao(){

    }

}
