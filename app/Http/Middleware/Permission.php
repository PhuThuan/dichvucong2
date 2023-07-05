<?php

namespace App\Http\Middleware;

use App\Models\GroupModel;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $currentUri = Route::current()->uri;;
        
        //check uri
        $user = Auth::user()->gr_id;
        $group_permission = GroupModel::find($user)->permission ?? '';
        //dd($currentUri);

        //dd(str_contains($group_permission,$currentUri));
        if(str_contains($group_permission,$currentUri)){

            return $next($request);

        }else{

            return redirect('/Error');
        }
        
    }
}
