<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return response()->redirectToRoute('admin.leads');
    }

    public function infusion(Request $request)
    {
        if($request->isMethod('post')){
            var_dump($request);
        }
    }
}
