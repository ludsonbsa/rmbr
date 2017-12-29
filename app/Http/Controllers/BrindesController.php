<?php

namespace App\Http\Controllers;

use App\Brindes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrindesController extends Controller
{

    public function index()
    {
        $brindes = DB::table('tb_contatos as t1')
        ->selectRaw('t1.id, t1.documento_usuario, t1.nome, t1.email, t1.telefone, t1.insercao_hotmart, t2.user_nome')
            ->join('users as t2', 't1.id_responsavel', '=','t2.id')
            ->whereRaw("(t1.conferencia_brinde = 0 AND t1.enviar_kit = 1) AND (t1.pos_atendimento = 'Boleto Gerado' OR t1.pos_atendimento = 'Vendido')")
            ->groupBy('t1.email')
            ->orderBy('t1.id', 'ASC')
            ->paginate(25);

        return view('brindes.listar', ['brindes' => $brindes]);
    }


    public function cadastrar(Request $request)
    {
        if(Brindes::create($request->all())){
            $msg = '<div class="alert alert-success"><strong>Brinde</strong> cadastrado com sucesso</div>';
        }else{
            $msg = '<div class="alert alert-danger"><strong>Brinde</strong> não cadastrado</div>';
        }
        return response()->redirectToRoute('admin.brindes.add')->with('message',$msg);
    }

    public function add(Request $request)
    {

        return view('brindes.add');
    }



    public function buscar(Request $request)
    {
        return view('brindes.buscar');
    }


    public function show(Brindes $brindes)
    {
        //
    }


    public function edit(Brindes $brindes)
    {
        //
    }


    public function update(Request $request, Brindes $brindes)
    {
        //
    }


    public function destroy(Brindes $brindes)
    {
        //
    }
}
