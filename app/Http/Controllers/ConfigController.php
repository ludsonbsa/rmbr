<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('config.config');
    }


    public function dashboard()
    {
        return view('config.dashboard');
    }


    public function store(Request $request)
    {
        //
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
