<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$age): Response
    {
        //Before Middleware
        //$age = 16;
        if($age<18 ){
            abort(403,'Age Doesnot meet Requirment , Access Denied');
        }
        return $next($request);
        ////////////////
        //After Middleware
        // $reponse = $next($request);
        // $age = 16;
        // if($age < 18){
        //     abort(403,'Age Doesnot meet Requirment , Access Denied');
        // }
        //     return $reponse;

    }
}
