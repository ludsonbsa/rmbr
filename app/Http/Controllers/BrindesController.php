<?php

namespace App\Http\Controllers;

use App\Brindes;
use Illuminate\Http\Request;

class BrindesController extends Controller
{

    public function index()
    {
        $listar = Brindes::all();

        return view('brindes.listar', ['brindes' => $listar]);
    }


    public function add()
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
