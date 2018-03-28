<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Atendente
{

    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 3 || Auth::user()->role != 1 || Auth::user()->role != 2){
            return redirect('/');
        }else{
            return $next($request);
        }
    }
}
