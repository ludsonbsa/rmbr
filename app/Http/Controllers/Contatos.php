<?php

namespace App\Http\Controllers;

use App\Contato;
use Illuminate\Http\Request;

use App\Http\Requests;

class Contatos extends Controller
{
    public function index(Request $request){
        $str = $request->get('str',"");

        if($str){
            //$courses = Course::where('name','like','%'.$str.'%')->orWhere('description','like','%'.$str.'%')->get();
            //Search que vai buscar no algolia através do searchable(trait) inserida no controller
            $contatos = Contato::search($str)->get();
        }else{
            $contatos = Contato::all();
        }

        return view('contatos.angular', ['contatos' => $contatos, 'str' => $str]);
    }
}
