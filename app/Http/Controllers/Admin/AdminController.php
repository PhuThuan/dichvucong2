<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TypeData;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\ServicesModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{
    public function getInfo(){

        return Inertia::render('Admin',['users' => User::all()]);
    }
    public function getService(){
        $data = ServicesModel::all();
        return Inertia::render('Admin_Managerment_Services', ['services' => $data]);
    }
     public function getDataUsers($status,$perPage){

        $dataServices = ServicesModel::all();
        $dataResult= [];
      //  dd($dataService);
        foreach($dataServices as $dataService){
                $model_name= $dataService['model_name'];

                // data type array
                if($status == 1){
                    $data_model= eval("return   \\App\\Models\\" . $model_name . "::where('status',".$status.")->orderBy('created_at','desc')->get();");
                }else  if($status == 2){
                    $data_model= eval("return \\App\\Models\\" . $model_name . "::all();");
                }else {
                    $data_model= eval("return \\App\\Models\\" . $model_name . "::all()->where('status',".$status.");");
                }
               
                //get status == disable
                //$data_model::where('status',TypeData::status['disable']);
                //dd($data_model);  
                foreach($data_model as $data){

                    $user= User::find($data['user_id']);
                  
                    array_push($dataResult,[
                        'phone' =>  $user['phone'],
                        'created_at' =>Carbon::parse($data['created_at'])->toDateTimeString() ,
                        'service_name' => $dataService['name'],
                        'service_id'=> $dataService['id'].'/'.$data['id'],
                        'status'=> $data['status'],

                    ]);
                }
                
        }

        dd($this->arrayPaginate($items=$dataResult,$perPage=10));

    }
    public function  arrayPaginate ($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function getUserAll($page){
        $users=User::where('role','=',TypeData::roleUser['user'])->paginate(10, ['*'], 'page', $page);
        $usersCount = User::where('role','=',TypeData::roleUser['user'])->count();
        $data=  [
            'users'=> $users,
            'usersCount'=> $usersCount,
          ];
         return Inertia::render('Customer_Management',['data'=>$data,'page'=>$page]);
    }
    public function notification(){
        $dataServices = ServicesModel::all();
        $dataResult= [];
      //  dd($dataService);
        foreach($dataServices as $dataService){
                $model_name= $dataService['model_name'];

                // data type array
              
                    $data_model= eval("return \\App\\Models\\" . $model_name . "::all()->where('status','0');");
               
                //get status == disable
                //$data_model::where('status',TypeData::status['disable']);
                //dd($data_model);  
                foreach($data_model as $data){

                    $user= User::find($data['user_id']);
                  
                    array_push($dataResult,[
                        'phone' =>  $user['phone'],
                        'created_at' =>$data['created_at'],
                        'service_name' => $dataService['name'],
                        'service_id'=> $dataService['id'],
                        'id' =>$data['id'],
                        'status'=> $data['status'],
                        'ho_va_ten'=>$data['ho_va_ten']?? '???',
                    ]);
                }
                
        }

        dd($dataResult);
    }
}
