<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Inertia\Inertia;

class UserController extends Controller
{
    public function getService(){
        return Inertia::render('Dashboard',['services' => Service::all()->where('avaiable','1')]);
    }
}
