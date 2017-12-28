<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Helpers\Uploader;

class PlanilhaImport extends Uploader
{
    protected $arquivoPlanilha;
    protected $query;
    protected $table;
    protected $pdo;
    protected $query2;
    protected $result;

    public function __construct(){
        //Utilizar conexão PDO
        //$this->pdo = \App\Conn::getDb();
        $this->pdo = DB::getPdo();
    }

    public function getArquivoPlanilha()
    {
        return $this->arquivoPlanilha;
    }

    /***
     * @param ArquivoPlanilha
     * Define a planilha a ser aberta, e abre-a.
     ***/
    public function setArquivoPlanilha()
    {
        $this->arquivoPlanilha = parent::getArquivo();

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getTable()
    {
        return $this->table;
    }


    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /***
     * @return Devolve a query de insert dentro de um While para gerar os resultados no formato padr�o de planilha do Hotmart.
     * @param @id = Id do Responsável pela inserção
     *
     ***/
    public function queryHotmart($id)
    {

        if(!($this->getArquivo())){
            echo "Necessário determinar o arquivo arquivo";
        }

        $this->query = "LOAD DATA LOCAL INFILE '".parent::getDestino().$this->getArquivo()."' INTO TABLE tb_contatos CHARACTER SET UTF8 FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES
	    (nome_do_produto, nome_do_produtor, documento_produtor, nome_afiliado, transacao, meio_de_pagamento, origem, moeda_1, preco_do_produto, moeda_2, preco_da_oferta, taxa_de_cambio, moeda_3, preco_original, numero_da_parcela, recorrencia, data_de_venda, data_de_confirmacao, status, nome, documento_usuario, email, ddd, telefone, cep, cidade, estado, bairro, pais, endereco, numero, complemento, chave, codigo_produto, codigo_afiliacao, codigo_oferta, origem_checkout, tipo_de_pagamento, periodo_gratis, coproducao, origem_comissao, preco_total, tipo_pagamento,insercao_hotmart,prioridade, observacao, id_responsavel, conferencia) set insercao_hotmart = 'Hotmart', prioridade = 'Oportunidade Hotmart', id_responsavel = '".$id."', conferencia = 0;";

        try{
            $this->pdo->query($this->query);
        }catch (\PDOException $e){
            return $e->getCode()." - ".$e->getMessage()." - ".$e->getLine();
        }
        return $this;
    }

    public function queryHotmart_aprovados()
    {

        if(!($this->getArquivo())){
            echo "Necessário determinar o arquivo arquivo";
        }
        //puxar da outra tabela
        $this->query = "SELECT nome, documento_usuario, email, status FROM tb_contatos WHERE status = 'aprovado'";

        //$this->query2 = "INSERT INTO tb_contatos_aprovados (nome, documento_usuario, email, status) VALUES () ";

        try{
            $this->pdo->query($this->query);
            //$this->pdo->query($this->query2);
        }catch (\PDOException $e){
            return $e->getCode()." - ".$e->getMessage()." - ".$e->getLine();
        }
        return $this;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }


    public function queryRecuperacao($id, array $date)
    {

        if(!($this->getArquivo())){
            echo "Necessário determinar o arquivo arquivo";
        }

        $this->query = "LOAD DATA LOCAL INFILE '".parent::getDestino().$this->getArquivo()."' INTO TABLE tb_contatos CHARACTER SET UTF8 FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES
	     (nome_do_produto, nome_do_produtor, documento_produtor, nome_afiliado, transacao, meio_de_pagamento, origem, moeda_1, preco_do_produto, moeda_2, preco_da_oferta, taxa_de_cambio, moeda_3, preco_original, numero_da_parcela, recorrencia, data_de_venda, data_de_confirmacao, status, nome, documento_usuario, email, ddd, telefone, cep, cidade, estado, bairro, pais, endereco, numero, complemento, chave, codigo_produto, codigo_afiliacao, codigo_oferta, origem_checkout, tipo_de_pagamento, periodo_gratis, coproducao, origem_comissao, preco_total, tipo_pagamento,insercao_hotmart,prioridade, observacao, id_responsavel, conferencia)
	     set insercao_hotmart = 'R.Hotmart', prioridade = 'Recuperação Hotmart', id_responsavel = '".$id."', conferencia = 0, nome_do_produto = '".$date['prod']."', nome_do_produtor = 'MBR EDITORA', documento_produtor = '26.762.111/0001-29', nome_afiliado = 'Leandro Ladeira', transacao = '".$date['url']."', meio_de_pagamento = 'HotPay', origem = '', moeda_1 = 'BRL', preco_do_produto = '',  moeda_2 = 'BRL', preco_da_oferta = '', taxa_de_cambio = '', moeda_3 = '', preco_original = '', numero_da_parcela = '', recorrencia = '', data_de_venda = '', data_de_confirmacao = '', status = 'Cancelado', email = '".$date['email']."', nome ='".$date['nome']."', ddd = '".$date['ddd']."', telefone = '".$date['telefone']."', cidade = '".$date['cidade']."', documento_usuario = '".$date['cpf']."', data_de_venda = '".date('d-m-Y H:i:s')."'";

        try{
            $this->pdo->query($this->query);
            $this->result = "Planilha Importada com sucesso";
        }catch (\PDOException $e){
            return $e->getCode()." - ".$e->getMessage()." - ".$e->getLine();
            $this->result = "Planilha não cadastrada: ".$e->getCode()." - ".$e->getMessage()." - ".$e->getLine();
        }
        return $this;
    }

}