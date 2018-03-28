<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class role
{

    public function handle($request, Closure $next)
    {
        if(Auth::user()->role != 1){
           return redirect('/');
        }else{
            return $next($request);
        }
    }
}
