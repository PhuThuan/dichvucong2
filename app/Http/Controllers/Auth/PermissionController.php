<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GroupModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PermissionController extends Controller
{


    public function getUserPermission()
    {
        $data_group =   GroupModel::all();
        $data_url = [];
        // Artisan::call('route:list');
        // return Artisan::output();
        $dataRoute = Route::getRoutes();
        foreach ($dataRoute as $data) {
           array_push($data_url,$data->uri) ;
        }
        dd($dataRoute);
        $data_user=[];
        foreach (User::all() as $data) {
            array_push($data_user,$data['email']) ;
        }
        $data = [
            'group' =>  $data_group,
            'user' =>$data_user,
            'url' => $data_url,
        ];

        return Inertia::render('Permission',['data'=>$data]);
    }

    public function getRoute(){
        return Route::current()->uri;
    }
}
