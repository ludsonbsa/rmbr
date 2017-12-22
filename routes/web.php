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
        Route::get('home', 'HomeController@index')->name('home');

        //LEADS
        Route::get('leads', 'ContatosController@index')->name('leads');

        //Atender atribui as informações de atendente
        Route::get('leads/atender/{id}', 'ContatosController@atender')->name('atender');

        //Editar não atribui informações de quem está editando
        Route::get('leads/editar/{id}', 'ContatosController@find')->name('lead.editar');

        //Adicionar Lead
        Route::get('leads/add/', 'ContatosController@add')->name('lead.add');
        //FIM DE LEADS

        //COMISSOES
        Route::get('comissoes/', 'ComissoesController@conferencia')->name('comissoes.listar');

        Route::get('teste', 'ContatosController@teste')->name('teste');

        Route::get('leads/importar', 'ImportacoesController@index')->name('importar');

        /****************USUÁRIOS****************/
        Route::get('usuarios/listar', 'UserController@index')->name('listar.usuarios');

    });


});

