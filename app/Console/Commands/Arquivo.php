<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Arquivo extends Command implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Importar Arquivo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $id;
    public $caminho;

    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        file_put_contents(public_path()."/uploads/planilhas/x.txt", "Gravou");
    }

    public function queryHotmart($id){
        $pdo = DB::connection()->getPdo();
        $query = "LOAD DATA LOCAL INFILE '".$$caminho."' INTO TABLE tb_contatos CHARACTER SET UTF8 FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES
	    (nome_do_produto, nome_do_produtor, documento_produtor, nome_afiliado, transacao, meio_de_pagamento, origem, moeda_1, preco_do_produto, moeda_2, preco_da_oferta, taxa_de_cambio, moeda_3, preco_original, numero_da_parcela, recorrencia, data_de_venda, data_de_confirmacao, status, nome, documento_usuario, email, ddd, telefone, cep, cidade, estado, bairro, pais, endereco, numero, complemento, chave, codigo_produto, codigo_afiliacao, codigo_oferta, origem_checkout, tipo_de_pagamento, periodo_gratis, coproducao, origem_comissao, preco_total, tipo_pagamento,insercao_hotmart,prioridade, observacao, id_responsavel, conferencia) set insercao_hotmart = 'Hotmart', prioridade = 'Oportunidade Hotmart', id_responsavel = '".$id."', conferencia = 0;";

        $pdo->exec($query);
        return $this;
    }
}
