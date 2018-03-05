<?php

namespace App\Http\Controllers;

use App\Contatos;
use App\Importacoes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\QueryException;
use App\Helpers;



class ImportacoesController extends Controller
{
    public $arquivo;

    public function index()
    {
        return view('contatos.importar');
    }

    private function setArquivo($arquivo){
        return $this->arquivo = $arquivo;
    }

    public function getArquivo(){
       return $this->arquivo;
    }

    public function planilhaImport()
    {

        if(Input::hasFile('planilha')){
            //Se não existir pasta de planilhas
            $logicpath = public_path().'/uploads/planilhas';
            if (!is_dir($logicpath)) {
                mkdir($logicpath, 0777, true);
            }

            $this->aprovados();

            //Move planilha pra pasta de planilhas
            $file = Input::file('planilha');
            $fileExtension = $file->getClientOriginalExtension();

            //Verifica se o arquivo é CSV.
            if($fileExtension == 'csv'){

                //Faz upload antes da importação

                #Seria bom pegar o nome do arquivo, mudar para um padrão sempre.
                $filename = $file->getClientOriginalName();

                $insere = $file->move($logicpath, $file->getClientOriginalName());


                # Abrir o arquivo em CSV
                $handle1 = fopen($logicpath."/".$file->getClientOriginalName(), 'r');

                #Seto o nome do arquivo e salvo na função
                $this->setArquivo(env('DOCUMENT_ROOT')."uploads/planilhas/".$file->getClientOriginalName());

                # Ler as linhas separadas por ; somente as verdadeiras ou existentes
                while (($datas = fgetcsv($handle1, 1000, ";")) !== FALSE) {

                    if(!empty($datas[18]) && $datas[21]){

                        #Atribui os campos de e-mail e status as variáveis
                        $status = $datas[18];
                        $email = $datas[21];

                        try {
                            $results = DB::table('tb_contatos')
                                ->whereRaw("email = '{$email}' AND (status != 'Aprovado' OR status != 'Completo') AND (pos_atendimento IS NULL)")->get();

                            foreach ($results as $v):
                                $dad = [
                                    'status' => $status
                                ];
                                //ler se existe, em caso afirmativo faz o update
                                $query =
                                    DB::table('tb_contatos')
                                    ->where('email', $email)
                                    ->update($dad);
                            endforeach;

                        } catch (QueryException $e) {
                            echo $e->getMessage();
                        }
                    }
                }

                fclose($handle1);

                #Executa query que insere os dados de planilha no banco de dados
                $this->queryHotmart(Auth::id());
                $this->aprovados();

            }else{
                return back()->with('msg-error',"Permitido somente arquivos em .CSV");
            }
        }
        return back()->with('msg',"Planilha adicionada com sucesso!");

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
        $aprovados = DB::select("SELECT nome_do_produto, nome, documento_usuario, status, email, transacao FROM tb_contatos WHERE status = 'aprovado' OR status = 'completo'");

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

        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $cpf = $data[2];
            $email = $data[4];

            $query = "SELECT id ,documento_usuario, email, status
        FROM tb_contatos WHERE documento_usuario LIKE '%{$cpf}%' AND (status = 'Aprovado' OR status = 'completo')";

            #Se vazio CPF, então busca por e-mail
            if (empty($cpf)) {
                $query = "SELECT id, documento_usuario, email, status
        FROM tb_contatos WHERE email LIKE '%{$email}%' AND (status = 'aprovado' OR status = 'completo')";

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
        #$this->verificapa();
        #$this->atribuirPosAt();
        //REZA!
        return $this;
    }

    public function planilhaRecuperacao(){

    }

}
