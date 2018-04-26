<?php

namespace App\Jobs;

use App\Mail\UserImporter;
use Illuminate\Bus\Queueable;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers;
use Illuminate\Support\Facades\Mail;

class ImportarPlanilha implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $id;
    public $arquivo;
    public $email;

    public function __construct($id, $arquivo, $email)
    {
        $this->id = $id;
        $this->setArquivo($arquivo);
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * @param mixed $arquivo
     */
    public function setArquivo($arquivo)
    {
        $this->arquivo = $arquivo;
    }



    public function handle(){
        $this->queryHotmart($this->id);
        $this->aprovados();
        $this->verificapa();
        $this->atribuirPosAt();
        Mail::to($this->email)->send(new UserImporter());

    }

    public function queryHotmart($id){
        $pdo = DB::connection()->getPdo();
        $query = "LOAD DATA LOCAL INFILE '".$this->getArquivo()."' INTO TABLE tb_contatos CHARACTER SET UTF8 FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES
	    (nome_do_produto, nome_do_produtor, documento_produtor, nome_afiliado, transacao, meio_de_pagamento, origem, moeda_1, preco_do_produto, moeda_2, preco_da_oferta, taxa_de_cambio, moeda_3, preco_original, numero_da_parcela, recorrencia, data_de_venda, data_de_confirmacao, status, nome, documento_usuario, email, ddd, telefone, cep, cidade, estado, bairro, pais, endereco, numero, complemento, chave, codigo_produto, codigo_afiliacao, codigo_oferta, origem_checkout, tipo_de_pagamento, periodo_gratis, coproducao, origem_comissao, preco_total, tipo_pagamento,insercao_hotmart,prioridade, observacao, id_responsavel, conferencia) set insercao_hotmart = 'Hotmart', prioridade = 'Oportunidade Hotmart', id_responsavel = '".$id."', conferencia = 0;";
        $pdo->exec($query);

        \Log::info("Foi QueryHOTMART");
    }

    public function aprovados()
    {
        #Adicionar linhas do banco de dados no arquivo CSV
        $executionStartTimeAP = microtime(true);

        $aprovados = DB::select("SELECT nome_do_produto, nome, documento_usuario, status, email, transacao FROM tb_contatos WHERE (status = 'aprovado' OR status = 'completo') AND completo = 0");
        $executionStartTimeAPEND = microtime(true);

        $totalAP = $executionStartTimeAPEND - $executionStartTimeAP;
        \Log::info("SELECT AP - Aprovados e completos: {$totalAP}");

        $csv = new Helpers\CSV();
        #Instanciar gerador CSV*/
        foreach ($aprovados as $registro) {
            #Adiciona a linha de cada aprovado
            $csv->addLine(new Helpers\CSVLine($registro->nome_do_produto, $registro->nome, $registro->documento_usuario, $registro->status, $registro->email, $registro->transacao));
        }


        $csv->save(public_path() . "/uploads/planilhas/aprovados.csv");


        #Abrir o arquivo com os aprovados pra não precisar ler aprovados mais de uma vez
        $handle = fopen(public_path() . '/uploads/planilhas/aprovados.csv', "r");

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
                    'aprovado' => 1,
                    'completo' => 2
                ];
                //ler se existe, em caso afirmativo faz o update
                DB::table('tb_contatos')
                    ->where('id', $re->id)
                    ->update($dad);
                echo "Primeiro Update \n";

                #Vai Acrescentando os valores de CPF e email nos arrays.
                array_push($cpfs, $re->documento_usuario);
                array_push($emails, $re->email);
            endforeach;
            /******
             * Fazer uma consulta de CPF dentro dos CPF existentes aprovados, e marcar CAMPO aprovado = 1
             * mesmo para os CPFs com estado cancelados ou expirados porem que já possuam algum status aprovado ou completo.
             *****/

        }
        #Coloquei agora pra fazer fora da leitura, um teste apenas.
        foreach ($cpfs as $indice => $valor):
            if (!empty($valor)) {
                $updateS = ['aprovado' => 1, 'completo' => 2];
                try {
                    DB::table('tb_contatos')
                        ->where('documento_usuario', $valor)
                        ->update($updateS);
                    echo "Item por cpf :" . $valor . "\n";
                } catch (\PDOException $e) {
                    return $e->getCode() . $e->getMessage();
                }
            }
        endforeach;

        foreach ($emails as $indice => $valor):
            if (!empty($valor)) {
                $updateS = ['aprovado' => 1, 'completo' => 2];
                echo "Item por e-mail :" . $valor . "\n";
                try {
                    DB::table('tb_contatos')
                        ->where('email', '=',  $valor)
                        ->update($updateS);
                } catch (\PDOException $e) {
                    return $e->getCode() . $e->getMessage();
                }
            }
        endforeach;

        $executionStartTimeALLAP2 = microtime(true);
        $totalAP2 = $executionStartTimeALLAP2 - $executionStartTimeALLAP;
        \Log::info("SELECT AP - Pega os ap com cpf e email: {$totalAP2}");
    }


    public function verificapa(){
        #Função que registra em um CSV Todos os pos_atendimentos EXISTENTES, que ja recebeu atendimento pela atendente.
        #BUSCANDO OS REGISTROS
        $executionStartTimeVAT1 = microtime(true);
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

        $csv->save(public_path() . "/uploads/planilhas/pos_atendimento.csv");

        $executionStartTimeALLVAT = microtime(true);
        $totalAP4 =  $executionStartTimeALLVAT - $executionStartTimeVAT1;
        \Log::info("Verificar pós atendimentos: {$totalAP4}");
    }

    public function atribuirPosAt(){
        #Modificar
        $executionStartTimeAT1 = microtime(true);

        $handle = fopen(public_path() . '/uploads/planilhas/pos_atendimento.csv', "r");

        $cpfs = array();
        $emails = array();
        $telefones = array();

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $cpf = $data[2];
            $email = $data[3];
            $telefone = $data[4];

            $bus = "SELECT id, documento_usuario, email, telefone, nome
        FROM tb_contatos
        WHERE documento_usuario LIKE '%{$cpf}%' AND pos_atendimento IS NULL AND completo = 0";

            if (empty($cpf)) {
                $bus = "SELECT id, documento_usuario, email, telefone, nome
        FROM tb_contatos
        WHERE email LIKE '%{$email}%' AND pos_atendimento IS NULL AND completo = 0";
            }
            if (empty($email)) {
                $bus = "SELECT id, documento_usuario, email, telefone, nome
        FROM tb_contatos
        WHERE telefone = '{$telefone}' AND pos_atendimento IS NULL AND completo = 0";
            }

            $result = DB::select($bus);

            foreach ($result as $re):

                $dad = ['pos_atendimento' => 1];
                //ler se existe, em caso afirmativo faz o update
                DB::table('tb_contatos')
                    ->where('id', $re->id)
                    ->update($dad);

                array_push($cpfs, $re->documento_usuario);
                array_push($emails, $re->email);
                array_push($telefones, $re->telefone);

            endforeach;
        }
        fclose($handle);

        $executionStartTimeALLAT = microtime(true);
        $totalAP3 =  $executionStartTimeALLAT - $executionStartTimeAT1;
        \Log::info("Atribuir pós atendimentos: {$totalAP3}");
    }

}
