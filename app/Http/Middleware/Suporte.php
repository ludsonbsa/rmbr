<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Suporte
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 4){
            return redirect('/');
        }else{
            return $next($request);
        }
    }
}
