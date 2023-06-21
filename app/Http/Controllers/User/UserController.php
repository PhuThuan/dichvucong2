<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ServicesModel;
use App\Models;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Enums\TypeData;
use Inertia\Inertia;


class UserController extends Controller
{
    public function getService(){
        
        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'services' => ServicesModel::all()->where('status',TypeData::status['enable']),
        ]);
    }
    public function contact(){
        
        return Inertia::render('CustomerSupportCenter');
    }

    public function showDataCustomer($page, $perPage) {
        $customers =  Models\User::paginate($perPage, ['*'], 'page', $page);
        return Inertia::render('Customer_Management', ['customers' => $customers]);
        // return response()->json($customers); test postman
    }
    public function showService(){
        return ServicesModel::all()->where('avaiable',TypeData::status['enable']);

    }

    public function getDataForm($id_service){
        
        $serviceFields = ServicesModel::find($id_service)->servicesFields->get();
        //dd($serviceFields);
        foreach($serviceFields as $field){
            if($field['html_type'] == TypeData::htmlType['radio'] || $field['html_type'] == TypeData::htmlType['checkbox'] || $field['html_type'] == TypeData::htmlType['select']){
                $field->serviceFieldValue;
            }
        }
        return Inertia::render('OrderCreateForm',['id'=>$id_service,'services' => $serviceFields]);
    }

    public function createDataUser(Request $request){

        
        if($model_name =ServicesModel::find(7)['model_name']){
            $data = $request->all();

            $dataConvert = "[";
            foreach($data as $key => $val){
                $dataConvert.= "'".$key . "'=>'" . $val ."'" .",";
            }
            $dataConvert .= "]";
    
            //dd($data);
            return eval("return \\App\\Models\\".$model_name."::create(".$dataConvert.");");
        }else {
            //return notifi model not found
        }
       

    }
}
