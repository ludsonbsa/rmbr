<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_contatos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome_do_produto', 255)->nullable();
            $table->string('nome_do_produtor', 255)->nullable();
            $table->string('documento_produtor', 255)->nullable();
            $table->string('nome_afiliado', 150)->nullable();
            $table->string('transacao', 100)->unique()->nullable();
            $table->string('meio_de_pagamento', 100)->nullable();
            $table->string('origem', 255)->nullable();
            $table->string('moeda_1', 144)->nullable();
            $table->string('preco_do_produto', 45)->nullable();
            $table->string('moeda_2', 45)->nullable();
            $table->string('preco_da_oferta', 45)->nullable();
            $table->string('taxa_de_cambio', 45)->nullable();
            $table->string('moeda_3', 45)->nullable();
            $table->string('preco_original', 45)->nullable();
            $table->string('numero_da_parcela', 45)->nullable();
            $table->string('recorrencia', 45)->nullable();
            $table->string('data_de_venda', 45)->nullable();
            $table->string('data_de_confirmacao', 45)->nullable();
            $table->string('status', 45);
            $table->string('nome', 255);
            $table->string('documento_usuario', 45)->nullable();
            $table->string('email', 145)->nullable();
            $table->string('ddd', 10)->nullable();
            $table->string('telefone', 45)->nullable();
            $table->string('cep', 45)->nullable();
            $table->string('cidade', 45)->nullable();
            $table->string('estado', 255)->nullable();
            $table->string('bairro', 145)->nullable();
            $table->string('pais', 145)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('numero', 45)->nullable();
            $table->string('complemento', 255)->nullable();
            $table->string('chave', 45)->nullable();
            $table->string('codigo_produto', 45)->nullable();
            $table->string('codigo_afiliacao', 45)->nullable();
            $table->string('codigo_oferta', 45)->nullable();
            $table->string('origem_checkout', 45)->nullable();
            $table->string('tipo_de_pagamento', 45)->nullable();
            $table->string('periodo_gratis', 45)->nullable();
            $table->string('coproducao', 45)->nullable();
            $table->string('origem_comissao', 45)->nullable();
            $table->string('preco_total', 45)->nullable();
            $table->string('tipo_pagamento', 45)->nullable();
            $table->string('insercao_hotmart', 255)->nullable();
            $table->longText('prioridade')->nullable();
            $table->longText('observacao')->nullable();
            $table->integer('id_responsavel')->nullable();
            $table->string('pos_atendimento',255)->nullable();
            $table->longText('obs_followup');
            $table->integer('conferencia');
            $table->integer('aprovado')->nullable();
            $table->integer('comissao_gerada')->nullable();
            $table->integer('enviar_kit')->nullable();
            $table->integer('conferencia_brinde');
            $table->integer('etiqueta_gerada')->nullable();
            $table->integer('arquivo_etiqueta')->nullable();
            $table->timestamp('data_ligar_depois');
            $table->integer('em_atendimento')->nullable();
            $table->timestamp('data_etiqueta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_contatos');
    }
}
