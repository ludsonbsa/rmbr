<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Comissoes;

class ComissoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //listagem das comissões a serem conferidas
        $query = DB::table('tb_comissoes as t1')
            ->selectRaw("COUNT(t1.com_id_user), SUM(t1.com_final), t1.com_id_user, t1.com_mes, t1.com_ano, t1.com_final, t1.com_pago, t1.com_produto, t2.user_nome, t2.avatar")
            ->join('users as t2','t1.com_id_user','=','t2.id')
            ->where("t2.id","!=", "10")
            ->groupBy('t1.com_id_user', 't1.com_mes','t1.com_ano')->get();

        return view('comissoes.listar', ['contatos' => $query]);
    }

    public function conferencia()
    {
        //listagem das comissões a serem conferidas
        $query = DB::table('tb_contatos as t1')
            ->selectRaw("t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t1.ddd, t2.user_nome")
            ->join('users as t2','t1.id_responsavel','=','t2.id')
            ->where("t1.conferencia","=", "0")
            ->whereRaw("(t1.pos_atendimento ='Boleto Gerado' OR t1.pos_atendimento = 
'Vendido')")
            ->where('t1.insercao_hotmart', '!=','Pagina Externa')
            ->orderBy('t2.id','ASC')->paginate(25);

        $count = Comissoes::count();

        return view('comissoes.listar', ['contatos' => $query, 'count' => $count]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
