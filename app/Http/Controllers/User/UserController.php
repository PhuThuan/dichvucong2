<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ServicesModel;
use App\Models;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Enums\TypeData;
use App\Models\ServicesFieldsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class UserController extends Controller
{
    public function getService()
    {

        return Inertia::render('Dashboard', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'services' => ServicesModel::all()->where('status', TypeData::status['enable']),
        ]);
    }
    public function contact()
    {

        return Inertia::render('CustomerSupportCenter');
    }

    public function showDataCustomer($page, $perPage)
    {
        $customers =  Models\User::paginate($perPage, ['*'], 'page', $page);
        return Inertia::render('Customer_Management', ['customers' => $customers]);
        // return response()->json($customers); test postman
    }
    public function showService()
    {
        return ServicesModel::all()->where('avaiable', TypeData::status['enable']);
    }

    public function getDataForm($id_service)
    {

        $serviceFields = ServicesModel::find($id_service)->servicesFields->get();
        //dd($serviceFields);
        foreach ($serviceFields as $field) {
            if ($field['html_type'] == TypeData::htmlType['radio'] || $field['html_type'] == TypeData::htmlType['checkbox'] || $field['html_type'] == TypeData::htmlType['select']) {
                $field->serviceFieldValue;
            }
        }
        return Inertia::render('OrderCreateForm', ['id' => $id_service, 'services' => $serviceFields]);
    }

    public function createDataUser(Request $request, $id_service)
    {
        $table_name=ServicesFieldsModel::get()->where('services_id',$id_service);
        
        $datatempt='';
        foreach($table_name as $dataService){
            
           $datatempt.='"'. $dataService['field_name'].'"' .'=>'. '"'.$dataService['validate']. '",';
            
        }
       
       
        $request->validate([
            $datatempt
            
        ]);
        if ($model_name = ServicesModel::find($id_service)['model_name']) {
            $data = $request->all();
            $data['status'] = TypeData::status['disable'];
            $data['user_id'] = Auth::user()->id;
            $data['service_id'] = (int)($id_service);
         
            // dd($data);
            $dataConvert = "[";
            foreach ($data as $key => $val) {
                $dataConvert .= "'" . $key . "'=>'" . $val . "'" . ",";
            }
            $dataConvert .= "]";

           // dd($dataConvert);
            eval("return \\App\\Models\\" . $model_name . "::create(" . $dataConvert . ");");

            return back()->with('message','thanhco ng');
         //   return to_route('dashboard');
        } else {
            //return notifi model not found
            return Inertia::share('OrderCreateForm',['notification'=>'không thành công']);
        }
    }
}
