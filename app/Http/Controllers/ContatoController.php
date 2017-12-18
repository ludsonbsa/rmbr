<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function listarContato()
    {
        $this->session->validaSession();

        /*VALIDAR PERMISSÕES*/
        $nivel = [1,2,3,4,6];
        $this->permissao->validarPermissao($nivel);
        /*VALIDAR PERMISSÕES*/

        if (isset($_GET['apagar'])) {
            $this->apagarRegistro();
        }
        /*USANDO PAGINATOR*/
        //Pega o get
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);

        //Registra na classe o link, primeira e ultima
        $paginator = new Helpers\Pager("/admin/contatos?atual=");

        //executa no link, com a quantidade de resultados
        $paginator->exePager($atual, 25);

        //chama container estático de consulta
        $registros = Container::getCrud('read');

        //faz a consulta
        if (isset($_GET['busca'])) {
            $pesquisa = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

            $this->view->contatos = $registros->fullRead("SELECT t1.id, t1.data_de_venda, t1.nome,t1.ddd, t1.telefone, t1.observacao, t1.email, t1.status, t1.documento_usuario, 
t1.em_atendimento, t1
.insercao_hotmart, t1
.prioridade,  t1.obs_followup, t1.id_responsavel, t2.user_nome FROM tb_contatos t1 INNER JOIN tb_users t2 ON (t1.id_responsavel = t2.user_id) WHERE (t1.aprovado IS NULL AND t1.pos_atendimento IS NULL) AND
t1.nome LIKE '%" . $pesquisa . "%' OR t1.email LIKE '%" . $pesquisa . "%' GROUP BY t1.email ORDER BY t1.id DESC LIMIT " . $paginator->getLimit() . " OFFSET " . $paginator->getOffset());

            $paginator->exePagintor("tb_contatos", "WHERE status != 'aprovado' AND nome LIKE '%" . $pesquisa . "%' OR email LIKE '%" . $pesquisa . "%' GROUP BY documento_usuario, email ORDER BY
 id ASC LIMIT " . $paginator->getLimit() . " OFFSET " . $paginator->getOffset());


        } else {
            //Aqui vai a regra do teste

            $this->view->contatos = $registros->fullRead("SELECT t1.id, t1.data_de_venda, t1.nome,t1.ddd, t1.telefone, t1.email, t1.obs_followup, t1.observacao, t1.status, t1.documento_usuario, t1.em_atendimento, t1.insercao_hotmart, t1
.prioridade, t1.id_responsavel, t2.user_nome FROM tb_contatos t1 INNER JOIN tb_users t2 ON (t1.id_responsavel = t2
.user_id) WHERE (t1.aprovado IS NULL AND t1.pos_atendimento IS NULL) AND (t1.status != 'Boleto Impresso' AND t1.status != 
'Expirado') GROUP BY t1.email ORDER
 BY t1.data_de_venda ASC LIMIT " . $paginator->getLimit() . " 
OFFSET " . $paginator->getOffset());

            $paginator->exePagintor("tb_contatos", "WHERE aprovado IS NULL AND pos_atendimento IS NULL AND (status != 'Boleto Impresso' AND status != 
'Expirado') GROUP BY email ORDER BY data_de_venda ASC");
        }

        /*//pega a paginação e passa pra view
        $this->view->paginator = $paginator->getPaginator();

        //Aba de Vendidos Não Conferidos
        $this->view->vendidos = $this->meusleads();
        //Aba de Não vendidos
        $this->view->nao_vendido = $this->nao_vendidos();
        //Boletos gerados
        $this->view->boletosGerados = $this->boletosGerados();
        ///Ligar Depois
        $this->view->ligarDepois = $this->ligarDepois();

        $this->view->expirados = $this->impressos_exp();

        $this->view->nao_atendidos = $this->nao_atendido();

        $this->view->agendado = $this->contatoAgendado();
        //Chamar não vendidos para ABA*/


        $this->render("contato/contato", false, false, false, true);

    }
}
