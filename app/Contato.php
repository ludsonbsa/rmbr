<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Contato extends Model
{
    use Searchable;

    protected $table = 'tb_contatos';

    protected $fillable = [
        'nome_do_produto',
        'nome_do_produtor',
        'documento_produtor',
        'nome_afiliado',
        'transacao',
        'meio_de_pagamento',
        'origem',
        'moeda_1' ,
        'preco_do_produto' ,
        'moeda_2' ,
        'preco_da_oferta' ,
        'taxa_de_cambio' ,
        'moeda_3' ,
        'preco_original' ,
        'numero_da_parcela' ,
        'recorrencia' ,
        'data_de_venda' ,
        'data_de_confirmacao' ,
        'status',
        'nome',
        'documento_usuario' ,
        'email' ,
        'ddd',
        'telefone',
        'cep',
        'cidade',
        'estado',
        'bairro' ,
        'pais',
        'endereco',
        'numero',
        'complemento',
        'chave' ,
        'codigo_produto' ,
        'codigo_afiliacao' ,
        'codigo_oferta' ,
        'origem_checkout' ,
        'tipo_de_pagamento' ,
        'periodo_gratis' ,
        'coproducao' ,
        'origem_comissao' ,
        'preco_total' ,
        'tipo_pagamento' ,
        'insercao_hotmart',
        'prioridade',
        'observacao',
        'id_responsavel',
        'pos_atendimento',
        'obs_followup',
        'conferencia',
        'enviar_kit',
        'conferencia_brinde'
    ];
}
