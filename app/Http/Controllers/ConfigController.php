<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = DB::table('tb_produtos')
            ->selectRaw("*")
            ->get();
        return view('config.config', ['produtos' => $produtos]);
    }


    public function dashboard()
    {
        return view('config.dashboard');
    }


    public function add_produto(Request $request)
    {
        var_dump($request);
    }


    public function show(Config $config)
    {
        //
    }


    public function edit(Config $config)
    {
        //
    }


    public function update(Request $request, Config $config)
    {
        //
    }


    public function destroy(Config $config)
    {
        //
    }
}
