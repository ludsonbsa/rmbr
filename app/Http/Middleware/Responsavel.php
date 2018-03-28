<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Responsavel
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 2){
            return redirect('/');
        }else{
            return $next($request);
        }
    }
}
