<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ServiceFieldValueModel;
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

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

use App\Models\User;
use Exception;
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
        if (isset($customers)) {
            return Inertia::render('Error');
        }
        return Inertia::render('Customer_Management', ['customers' => $customers]);
        // return response()->json($customers); test postman
    }
    public function showService()
    {
        return ServicesModel::all()->where('avaiable', TypeData::status['enable']);
    }

    public function getDataForm($id_service)
    {
        try {
            $serviceFields = ServicesModel::find($id_service)->servicesFields->get();


            if (!isset($serviceFields) && is_null($serviceFields)) {
                return Inertia::render('Error');
            }
            //dd($serviceFields);
            foreach ($serviceFields as $field) {
                if ($field['html_type'] == TypeData::htmlType['radio'] || $field['html_type'] == TypeData::htmlType['checkbox'] || $field['html_type'] == TypeData::htmlType['select']) {
                    $field->serviceFieldValue;
                }
            }
            return Inertia::render('OrderCreateForm', ['id' => $id_service, 'services' => $serviceFields]);
        } catch (Exception $e) {
            return Inertia::render('Error');
        }
    }

    public function createDataUser(Request $request, $id_service)
    {

        $table_name = ServicesFieldsModel::get()->where('services_id', $id_service);

        $datatempt = '';

        foreach ($table_name as $dataService) {

            $datatempt .= '"' . $dataService['field_name'] . '"' . '=>' . '"' . $dataService['validate'] . '",';
        }

        $request->validate([
            $datatempt

        ]);

        $path_file = [];
        ////handle file/////
        foreach($table_name as $value){
            //dd($value['field_name']);
            
            if($request->hasFile($value['field_name'])){

                $path_file[$value['field_name']] = 'file,'.$request->file($value['field_name'])->store(Auth::user()->id,'public');

            }
        }

        $modelService = ServicesModel::find($id_service);
        if (!isset($modelService)) {
            return Inertia::render('Error');
        }
        if ($model_name = $modelService['model_name']) {
            $data = $request->all();

            //handle file
            foreach($path_file as $key => $value){
                $data[$key] = $value;
            }

            $data['status'] = TypeData::status['disable'];
            $data['user_id'] = Auth::user()->id;
            $data['service_id'] = (int)($id_service);

            $dataConvert = "[";
            foreach ($data as $key => $val) {
                $dataConvert .= "'" . $key . "'=>'" . $val . "'" . ",";
            }
            $dataConvert .= "]";

            // dd($dataConvert);
            
                //check model
            if(!file_exists(app_path('Models/'. $model_name.'.php'))){
                return Inertia::render('Error');
            }
            eval("return \\App\\Models\\" . $model_name . "::create(" . $dataConvert . ");");
        
            
            /////send MAIL////////
            $dataMailForm = $data;
            $dataMailForm = $this->explodeFieldValue($dataMailForm);
            unset($dataMailForm['user_id']);
            unset($dataMailForm['status']);
            unset($dataMailForm['ho_va_ten']);
            $dataMailForm['email'] ?? Auth::user()->email;
            $dataMailForm['phone'] ?? Auth::user()->phone;
            $dataMailForm['service_name'] = $modelService['name'];
            
            $dataMail = [
                'name' => $request['ho_va_ten'],
                'message' => "Bạn đã tạo thành công dịch vụ " . $modelService['name'],
                'subject' => 'Dịch vụ '.$modelService['name'],
                'info' => $dataMailForm,
            ];
            
            
            Mail::to('123@gmail.com')->send(new SendMail($dataMail));
            

            return Inertia::render('OrderCreateForm', ['message' => 'Đã thêm yêu cầu thành công']);
            //   return to_route('dashboard');
        } else {
            //return notifi model not found
            return Inertia::render('OrderCreateForm', ['message' => 'Không thành công']);
        }
        //return Inertia::render('OrderCreateForm', ['message' => 'Không thành công']);
    }

    public function explodeFieldValue($data)
    {

        // $dataField = [];
        foreach ($data as $key => $value) {
            if (str_contains(explode(',', $value)[0], 'radio') || str_contains(explode(',', $value)[0], 'checkbox') || str_contains(explode(',', $value)[0], 'select') || str_contains(explode(',', $value)[0], 'file')) {
                $id = explode(',', $value);
                if($id[0] == 'file'){
                    $data[$key] = 'storage/'.$id[1];
                    //dd($data[$key]);
                    continue;
                }
                unset($id[0]);
                //dd($id);
                //get value form id field
                $dataField = '';
                foreach ($id as $field) {
                    $field_name = ServiceFieldValueModel::find($field)['name'];
                    if(!isset($field_name)){
                        return Inertia::render('Error');
                    }
                    $dataField .= $field_name;
                    $dataField .= ",";
                }
                $data[$key] = $dataField;
            }
        }
        
        return $data;
    }

    public function getUserService()
    {
        $user = User::find(Auth::user()->id);
        $services = ServicesModel::all();
        $dataService = [];
        foreach ($services as $service) {
            $model_name = $service['model_name'];
            //get service user used
            //check model
            if(!file_exists(app_path('Models/'. $model_name.'.php'))){
                return Inertia::render('Error');
            }
            $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('user_id'," . Auth::user()->id . ");");
            //dd($data_model);


            if (isset($data_model)) {

                foreach ($data_model as $value) {
                    array_push($dataService, [
                        'id' => $value['id'],
                        'created_at' => $value['created_at'],
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
