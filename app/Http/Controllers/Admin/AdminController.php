<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Enums\TypeData;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\ServiceFieldValueModel;
use App\Models\ServicesFieldsModel;
use App\Models\ServicesModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\GroupModel;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Group;

class AdminController extends Controller
{
    public function getInfo()
    {

        return Inertia::render('Admin', ['users' => User::all()]);
    }
    public function getService()
    {
        $data = ServicesModel::all();
        return Inertia::render('Admin_Managerment_Services', ['services' => $data]);
    }
    public function getDataUsers($service_id, $page = 1, $status = 4,)
    {
        // if ($status > 4 || $status < 0) {
        $dataServices = ServicesModel::where('id', $service_id)->get();
        $dataResult = [];
        $data_count = 0;
        //  dd($dataService);
        foreach ($dataServices as $dataService) {
            $model_name = $dataService['model_name'];
            //check model
            //dd(file_exists(app_path('Models/'. $model_name.'.php')));
            if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
                return Inertia::render('Error');
            }
            $modelClass = "\\App\\Models\\" . $model_name;
            $data_model = $modelClass::where('status', $status)->paginate(10, ['*'], 'page', $page);
            // $data_model = eval("return   \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->get();");
            $data_count = eval("return   \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->count();");
            if ($status == 4) {
                $modelClass = "\\App\\Models\\" . $model_name;
                $statuses = [0, 1, 2, 3];
                $data_model = $modelClass::whereIn('status', $statuses)->paginate(10, ['*'], 'page', $page);
                // $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->paginate(10);");
                $data_count = eval("return \\App\\Models\\" . $model_name . "::count();");
            } else {
                $data_model = $modelClass::where('status', $status)->paginate(10, ['*'], 'page', $page);

                // $data_model = eval("return   \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->get();");
                $data_count = eval("return   \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->count();");
            }

            //get status == disable
            //$data_model::where('status',TypeData::status['disable']);
            // dd($data_model);
            foreach ($data_model as $data) {

                $user = User::find($data['user_id']);

                array_push($dataResult, [
                    'phone' =>  $user['phone'],
                    'created_at' => Carbon::parse($data['created_at'])->toDateTimeString(),
                    'service_name' => $dataService['name'],
                    'service_id' => $dataService['id'],
                    'form_id' => $data['id'],
                    'status' => $data['status'],
                    'count' => $data_count,

                ]);
            }
        }
        // dd($dataResult);
        return Inertia::render('Admin_RequestsManagement', ['data' => $dataResult, 'count'=>$data_count,'status' => $status, 'service_id' => $service_id,'page'=>$page]);
    }

    public function  arrayPaginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function getUserAll($page)
    {
        $users = User::paginate(10, ['*'], 'page', $page);
        $usersCount = User::count();
        $data =  [
            'users' => $users,
            'usersCount' => $usersCount,
        ];
        return Inertia::render('Customer_Management', ['data' => $data, 'page' => $page]);
    }
    public function notification()
    {
        $dataServices = ServicesModel::all();
        $dataResult = [];
        //  dd($dataService);
        foreach ($dataServices as $dataService) {
            $model_name = $dataService['model_name'];

            // data type array
            try {
                //dd(file_exists(!app_path('Models/'. $model_name.'.php')));
                if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
                    return Inertia::render('Error');
                }
                $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('status','0');");
            } catch (Exception $e) {
                return Inertia::render('Error');
            }

            //$data_model::where('status',TypeData::status['disable']);
            //dd($data_model);  
            foreach ($data_model as $data) {

                $user = User::find($data['user_id']);

                array_push($dataResult, [
                    'phone' =>  $user['phone'],
                    'created_at' => $data['created_at'],
                    'service_name' => $dataService['name'],
                    'service_id' => $dataService['id'],
                    'id' => $data['id'],
                    'status' => $data['status'],
                    'ho_va_ten' => $data['ho_va_ten'] ?? '???',

                ]);
            }
        }

        return Inertia::render('NotiAdmin', ['noti' => $dataResult]);
    }

    public function changeStatus($status, $service_id, $id)
    {
        $data_table =   ServicesModel::find($service_id)->get();
        foreach ($data_table as $dataService) {
            $model_name = $dataService['model_name'];
            eval("return \\App\\Models\\" . $model_name . "::where('id'," . $id . ")->where('service_id'," . $service_id . ")->update(['status'=>" . $status . "]);");
        }


        $dataService = ServicesModel::find($service_id);
        if (!isset($dataService)) {
            return Inertia::render('Error');
        }
        $dataLabel = [];

        //array
        $dataServiceField = ServicesFieldsModel::where('services_id', $service_id)->get();
        if (!isset($dataServiceField)) {
            return Inertia::render('Error');
        }
        $model_name = $dataService['model_name'];
        //check model
        if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
            return Inertia::render('Error');
        }
        $data_model = eval("return \\App\\Models\\" . $model_name . "::find(" . $id . ");");
        if (!isset($data_model) && is_null($data_model)) {
            return Inertia::render('Error');
        }
        //convert to array
        $data_model = $data_model->toArray();

        //check multi-value and convert
        $data_model = $this->explodeFieldValue($data_model);
        //$data_model['label'] = $dataLabel;
        if (isset($dataServiceField)) {

            foreach ($dataServiceField as $value) {
                $dataLabel += [$value['field_name'] => $value['label']];
            }
        } else {
            return  Inertia::render('Error');;
        }
        $data_model['label'] = $dataLabel;
        $data_model['service_name'] = $dataService['name'];
        return $data_model;
    }

    public function orderDetail($service_id, $id)
    {
        $dataService = ServicesModel::find($service_id);
        if (!isset($dataService)) {
            return Inertia::render('Error');
        }
        $dataLabel = [];

        //array
        $dataServiceField = ServicesFieldsModel::where('services_id', $service_id)->get();
        if (!isset($dataServiceField)) {
            return Inertia::render('Error');
        }
        $model_name = $dataService['model_name'];
        //check model
        if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
            return Inertia::render('Error');
        }
        $data_model = eval("return \\App\\Models\\" . $model_name . "::find(" . $id . ");");
        if (!isset($data_model) && is_null($data_model)) {
            return Inertia::render('Error');
        }
        //convert to array
        $data_model = $data_model->toArray();

        //check multi-value and convert
        $data_model = $this->explodeFieldValue($data_model);
        //$data_model['label'] = $dataLabel;
        if (isset($dataServiceField)) {

            foreach ($dataServiceField as $value) {
                $dataLabel += [$value['field_name'] => $value['label']];
            }
        } else {
            return  Inertia::render('Error');;
        }
        $data_model['label'] = $dataLabel;
        $data_model['service_name'] = $dataService['name'];
        $user = Auth::user();

        // Truy cập vào thuộc tính 'role' của người dùng
        $role = $user->role;
        if ($data_model['status'] == 0) {
            $data_model = $this->changeStatus(2, $service_id, $id);
        }
        return Inertia::render('RequestDetails', ['data' => $data_model, 'role' => $role]);

        // dd($data_model['status']);
    }



    public function explodeFieldValue($data)
    {
        // $dataField = [];
        foreach ($data as $key => $value) {
            if (str_contains(explode(',', $value)[0], 'radio') || str_contains(explode(',', $value)[0], 'checkbox') || str_contains(explode(',', $value)[0], 'select') || str_contains(explode(',', $value)[0], 'file')) {
                $id = explode(',', $value);

                //handle file
                if ($id[0] == 'file') {
                    $data[$key] = 'storage/' . $id[1];
                    //dd($data[$key]);
                    continue;
                }

                unset($id[0]);
                //dd($id);
                //get value form id field
                $dataField = [];
                foreach ($id as $field) {
                    $field_name1 = ServiceFieldValueModel::find($field)['name'];
                    array_push($dataField, $field_name1);
                }
                $data[$key] = $dataField;
            }
        }
        //dd($data);
        return $data;
    }

    public function getUserService($user_id)
    {
        $user = User::find($user_id);
        if (!isset($user)) {
            return Inertia::render('Error');
        }
        try {
            $services = ServicesModel::all();
            $dataService = [];
            foreach ($services as $service) {
                $model_name = $service['model_name'];
                //check model 
                //dd(file_exists(app_path('Models/'. $model_name.'.php')));
                if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
                    return Inertia::render('Error');
                }
                //get service user used
                $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('user_id'," . $user_id . ");");
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
            $group = GroupModel::all();
            
            $dataResult = [
                'user_id' => $user['id'],
                'phone' => $user['phone'],
                'service' => $dataService,
                'group' => $group,
                'currentRole' => $user['role'],
                'role' => TypeData::roleUser(),
                'currentGroup' => $user['gr_id'],
            ];
            return Inertia::render('ProfileCustomerAdmin', ['data' => $dataResult]);
        } catch (Exception $e) {
            return Inertia::render('Error');
        }
    }

    public function storeUserInfo(Request $request,$user_id){
        if(Auth::user()->role!=TypeData::roleUser['admin']){  
            return Inertia::render('Error');
        }
            //dd($request->gr_id);
            
            $user = User::find($request->user_id);
            $user->gr_id = $request->gr_id;
            $user->save();
            
            return to_route('detailUser',['user_id' => $request->user_id]);
    }
    public function notihead()
    {
        $dataServices = ServicesModel::all();
        $dataResult = [];
        $data_count = 0;
        //  dd($dataService);
        foreach ($dataServices as $dataService) {
            $model_name = $dataService['model_name'];

            // data type array
            if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
                return Inertia::render('Error');
            }
            $data_count += eval("return \\App\\Models\\" . $model_name . "::where('status',0)->count();");
        }
        return response($data_count)->header('Content-Type', 'application/json');
    }

    public function getListService()
    {
        $data = ServicesModel::all()->where('status', TypeData::status['enable']);
        return Inertia::render('Admin_OrderCreate', ['services' => $data]);
    }
    public function getForm($id_service)
    {

        $serviceFields = ServicesModel::find($id_service)->servicesFields->get();
        $service_name = ServicesModel::find($id_service);

        // dd($serviceFields);
        foreach ($serviceFields as $field) {
            if ($field['html_type'] == TypeData::htmlType['radio'] || $field['html_type'] == TypeData::htmlType['checkbox'] || $field['html_type'] == TypeData::htmlType['select']) {
                $field->serviceFieldValue;
            }
        }
        return Inertia::render('Admin_OrderForm', ['id' => $id_service, 'services' => $serviceFields,'service_name'=>$service_name]);
    }

    public function createDataUser(Request $request, $id_service)
    {

        $table_name = ServicesFieldsModel::get()->where('services_id', $id_service);

        $datatempt = [];

        foreach ($table_name as $dataService) {

            //$datatempt += '\'' . $dataService['field_name'] . '\'' . '=>' . '\'' . $dataService['validate'] . '\',';
            $datatempt[$dataService['field_name']] = $dataService['validate'];
        }
        //dd( $datatempt);
        // $request->validate(
        //     $datatempt

        // );
        //handle validation
        $dataRequest = [];
        
        //dd(!str_contains($request->all()['ho_va_ten'],'select'));
        foreach($request->all() as $key => $data){
            if(isset($datatempt[$key]) && $datatempt[$key]!= NULL && !str_contains($data,'select') && !$request->hasFile($key) && !str_contains($data,'radio') && !str_contains($data,'checkbox') ){
                $dataRequest[$key] = $data;
            }else {
                unset($datatempt[$key]);
            }
        }
        //dd($datatempt);
        $validator = Validator::make($dataRequest,$datatempt);

        if($validator->fails()){
            return Inertia::render('Admin_OrderForm',['message'=>'Dữ liệu gửi không hợp lệ ! Tạo yêu cầu thất bại']);
        }
        $path_file = [];
        ////handle file/////
        foreach ($table_name as $value) {
            //dd($value['field_name']);

            if ($request->hasFile($value['field_name'])) {

                $path_file[$value['field_name']] = 'file,' . $request->file($value['field_name'])->store(Auth::user()->id, 'public');
            }
        }

        $modelService = ServicesModel::find($id_service);
        if (!isset($modelService)) {
            return Inertia::render('Error');
        }
        if ($model_name = $modelService['model_name']) {
            $data = $request->all();

            //handle file
            foreach ($path_file as $key => $value) {
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
            if (!file_exists(app_path('Models/' . $model_name . '.php'))) {
                return Inertia::render('Error');
            }
            eval("return \\App\\Models\\" . $model_name . "::create(" . $dataConvert . ");");


            /////send MAIL////////
            $dataMailForm = $data;
            $dataMailForm = $this->explodeFieldValue2($dataMailForm);
            unset($dataMailForm['user_id']);
            unset($dataMailForm['status']);
            unset($dataMailForm['ho_va_ten']);
            $dataMailForm['email'] ?? Auth::user()->email;
            $dataMailForm['phone'] ?? Auth::user()->phone;
            $dataMailForm['service_name'] = $modelService['name'];

            $dataMail = [
                'name' => $request['ho_va_ten'],
                'message' => "Bạn đã tạo thành công dịch vụ " . $modelService['name'],
                'subject' => 'Dịch vụ ' . $modelService['name'],
                'info' => $dataMailForm,
            ];
           
            try{
                foreach(User::all()->where('role',TypeData::roleUser['admin']) as $user){
                  //  dd($user['email']);
                    Mail::to($user['email'])->send(new SendMail($dataMail));
                }
           
            }catch(Exception $e){
                return Inertia::render('Error');
            }

            return Inertia::render('Admin_OrderForm', ['message' => 'Đã thêm yêu cầu thành công']);
            //   return to_route('dashboard');
        } else {
            //return notifi model not found
            return Inertia::render('Admin_OrderForm', ['message' => 'Không thành công']);
        }
        //return Inertia::render('OrderCreateForm', ['message' => 'Không thành công']);
    }

    public function updateStatus(Request $request, $service_id, $id)
    {
        // dd($request->status);
        $request->validate([
            'status' => 'required',
        ]);
        $data_model = $this->changeStatus($request->status, $service_id, $id);

        // dd($request->status);
        if ($request->status != 0) {
            return Inertia::render('RequestDetails', ['data' => $data_model]);
        }
    }


    public function explodeFieldValue2($data)
    {

        // $dataField = [];
        foreach ($data as $key => $value) {
            if (str_contains(explode(',', $value)[0], 'radio') || str_contains(explode(',', $value)[0], 'checkbox') || str_contains(explode(',', $value)[0], 'select') || str_contains(explode(',', $value)[0], 'file')) {
                $id = explode(',', $value);
                if ($id[0] == 'file') {
                    $data[$key] = 'storage/' . $id[1];
                    //dd($data[$key]);
                    continue;
                }
                unset($id[0]);
                //dd($id);
                //get value form id field
                $dataField = '';
                foreach ($id as $field) {
                    $field_name = ServiceFieldValueModel::find($field)['name'];
                    if (!isset($field_name)) {
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
}