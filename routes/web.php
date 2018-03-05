<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm');


Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('leads/listar', 'Contatos@listar');

    Route::group(['middleware' => 'can:admin'], function(){
        Route::get('home', 'ConfigController@dashboard')->name('home');
        //LEADS
        Route::get('leads', 'ContatosController@index')->name('leads');

        Route::get('leads/vendidos-nao-conferidos', 'ContatosController@vendidos_nao_conferidos')->name('leads.vendidos-nao-conferidos');

        Route::get('leads/nao-vendidos', 'ContatosController@nao_vendidos')->name('leads.nao-vendidos');

        Route::get('leads/boletos-gerados', 'ContatosController@boletos_gerados')->name('leads.nao-vendidos');

        Route::get('leads/ligar-depois', 'ContatosController@ligar_depois')->name('leads.ligar-depois');

        Route::get('leads/recuperar-boletos', 'ContatosController@recuperar_boletos')->name('leads.recuperar-boletos');

        Route::get('leads/nao-atendidos', 'ContatosController@nao_atendidos')->name('leads.nao_atendidos');

        Route::post('leads/atender-update/{id}', 'ContatosController@atender_update')->name('leads.atender_update');

        Route::post('leads/search', 'ContatosController@search')->name('leads.search');

        //Atender atribui as informações de atendente
        Route::get('leads/atender/{id}', 'ContatosController@atender')->name('atender');

        //Editar não atribui informações de quem está editando
        Route::get('leads/editar/{id}', 'ContatosController@find')->name('lead.editar');

        //Editar não atribui informações de quem está editando
        Route::get('leads/deletar/{id}', 'ContatosController@deletar')->name('lead.deletar');

        //Adicionar Lead
        Route::get('leads/add/', 'ContatosController@add')->name('lead.add');
        Route::put('leads/cadastrar', 'ContatosController@cadastrar')->name('lead.cadastrar');

        #Cancelar Atendimento
        Route::get('leads/cancelar/{id}', 'ContatosController@atender_cancelar')->name('lead.cancelar');

        #Importações
        Route::get('leads/importar', 'ImportacoesController@index')->name('importar');
        Route::post('leads/importar/upload', 'ImportacoesController@planilhaImport')
            ->name('importar.upload');

        #Leads Aprovados
        Route::get('leads/aprovados/', 'ImportacoesController@aprovados')->name('lead.aprovado');
        //FIM DE LEADS

        //COMISSOES
        Route::get('comissoes/', 'ComissoesController@conferencia')->name('comissoes.listar');
        Route::get('teste', 'ContatosController@teste')->name('teste');


        /****************USUÁRIOS****************/
        Route::get('usuarios/listar', 'UserController@index')->name('listar.usuarios');
        Route::put('usuarios/cadastrar', 'UserController@cadastrar')->name('cadastrar.usuarios');

        /*********BRINDES********/
        Route::get('brindes/listar', 'BrindesController@index')->name('listar.brindes');
        Route::get('brindes/add', 'BrindesController@add')->name('brindes.add');
        Route::put('brindes/cadastrar', 'BrindesController@cadastrar')->name('brindes.cadastrar');
        Route::get('brindes/buscar', 'BrindesController@buscar')->name('brindes.buscar');

        /*********CONFIG********/
        Route::get('config', 'ConfigController@index')->name('config');
        Route::get('dashboard', 'ConfigController@dashboard')->name('dashboard');
    });


});

