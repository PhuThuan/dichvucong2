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
use App\Models\User;
use Illuminate\Support\Carbon;

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
            return Inertia::render('OrderCreateForm',['message'=>'Đã thêm yêu cầu thành công']);
         //   return to_route('dashboard');
        } else {
            //return notifi model not found
            return Inertia::render('OrderCreateForm',['message'=>'Không thành công']);
        }
    }
    public function getUserService()
    {
        $user = User::find(Auth::user()->id);
        $services = ServicesModel::all();
        $dataService = [];
        foreach ($services as $service) {
            $model_name = $service['model_name'];
            //get service user used
            $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('user_id'," . Auth::user()->id . ");");
            //dd($data_model);


            if (isset($data_model)) {

                foreach ($data_model as $value) {
                    array_push($dataService, [
                        'id' => $value['id'],
                        'created_at' => Carbon::parse($value['created_at'])->toDateTimeString(),
                        'service_id' => $service['id'],
                        'service_name' => $service['name']
                    ]);

                }
            }
        }

        $dataResult = [
            'phone' => $user['phone'],
            'service' => $dataService,

        ];
        return Inertia::render('ProfileCustomer', ['data' => $dataResult]);
    }
}
