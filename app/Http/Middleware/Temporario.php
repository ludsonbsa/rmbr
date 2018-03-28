<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Temporario
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 6){
            return redirect('/');
        }else{
            return $next($request);
        }
    }
}
