<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
class checkAccountLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        //prevent user access admin page
        
        if (isset(Auth::user()->role)){
            if(Auth::user()->role==1){
                
                return $next($request);
            }
            if(Auth::user()->role!=1){
          
                return to_route('dashboard');
            } 
        }
        
        
        return $next($request);
    }
}
