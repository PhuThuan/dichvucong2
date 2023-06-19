<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function getInfo(){

        return Inertia::render('Admin',['users' => User::all()]);
    }
    public function getService(){
        $data = ServicesModel::all();
        return Inertia::render('Admin_Managerment_Services', ['services' => $data]);
    }
    
    
}
