<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Contatos::class, function (Faker $faker) {

    return [
        'nome_do_produto' => 'Pompoarismo Cátia Damasceno',
        'nome_do_produtor' => '',
        'documento_produtor' => '',
        'nome_afiliado' => '',
        'transacao' => NULL,
        'meio_de_pagamento' => '',
        'origem' => '',
        'moeda_1' => '',
        'preco_do_produto' => '',
        'moeda_2' => '',
        'preco_da_oferta' => '',
        'taxa_de_cambio' => '',
        'moeda_3' => '',
        'preco_original' => '',
        'numero_da_parcela' => '',
        'recorrencia' => '',
        'data_de_venda' => $faker->dateTime(),
        'data_de_confirmacao' => '',
        'status' => '',
        'nome' => $faker->name('Female'),
        'documento_usuario' => $faker->randomDigit,
        'email' => $faker->email,
        'ddd' => $faker->countryCode,
        'telefone' => $faker->phoneNumber,
        'cep' => $faker->randomDigit,
        'cidade' => $faker->city,
        'estado' => $faker->streetName,
        'bairro' => $faker->streetAddress ,
        'pais' => 'Brasil',
        'endereco' => $faker->address,
        'numero' => $faker->randomDigit,
        'complemento' => '',
        'chave' => '',
        'codigo_produto' => '',
        'codigo_afiliacao' => '',
        'codigo_oferta' => '',
        'origem_checkout' => '',
        'tipo_de_pagamento' => '',
        'periodo_gratis' => '',
        'coproducao' => '',
        'origem_comissao' => '',
        'preco_total' => '',
        'tipo_pagamento' => '',
        'insercao_hotmart' => "Pagina Externa",
        'prioridade' => 'Duvidas profundas sobre o curso',
        'observacao' => '',
        'id_responsavel' => 10,
        'pos_atendimento' => 'Vendido',
        'obs_followup' => 'Follow Up',
        'conferencia' => 1,
        'enviar_kit' => 1,
        'conferencia_brinde' => 0,
    ];
});
