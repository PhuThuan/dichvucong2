<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class UserController extends Controller
{
    public function getService(){
        
        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'services' => Service::all()->where('avaiable','1'),
        ]);
    }
    public function contact(){
        
        return Inertia::render('CustomerSupportCenter');
    }
}
