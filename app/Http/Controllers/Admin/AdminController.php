<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\ServicesModel;
use App\Models\thuanj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function getInfo(){

        return Inertia::render('Admin',['users' => User::all()]);
    }
    public function getService(){
        $data = ServicesModel::all();
        return Inertia::render('Admin_Managerment_Services', ['services' => $data]);
    }
     public function getDataUsers($user_id){

        $dataServices = ServicesModel::all();
        $dataResult= [];
      //  dd($dataService);
        foreach($dataServices as $dataService){
                $model_name= $dataService['model_name'];

                // data type array
                $data_model= eval("return \\App\\Models\\" . $model_name . "::all();");
                //dd($data_model);
                foreach($data_model as $data){
                    
                    $user= User::find($user_id);
                  
                    array_push($dataResult,[
                        'phone' =>  $user['phone'],
                        'created_at' =>Carbon::parse($data['created_at'])->toDateTimeString() ,
                        'service_name' => $dataService['name'],
                        'service_id'=> $dataService['id'],
                    ]);
                }
                
        }

        dd($dataResult);
    }
    
}
