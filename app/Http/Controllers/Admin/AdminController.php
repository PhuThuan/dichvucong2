<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
    public function getDataUsers($status)
    {

        $dataServices = ServicesModel::all();
        $dataResult = [];
        $data_count = 0;
        //  dd($dataService);
        foreach ($dataServices as $dataService) {
            $model_name = $dataService['model_name'];

            // data type array
            if ($status == 1) {
                $data_model = eval("return   \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->get();");
                $data_count = eval("return   \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->count();");
            } else  if ($status == 2) {
                $data_model = eval("return \\App\\Models\\" . $model_name . "::all();");
                $data_count = eval("return \\App\\Models\\" . $model_name . "::count();");
            } else {
                $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('status'," . $status . ");");
                $data_count = eval("return \\App\\Models\\" . $model_name . "::where('status'," . $status . ")->count();");
            }

            //get status == disable
            //$data_model::where('status',TypeData::status['disable']);
            //dd($data_model);  
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
        return Inertia::render('Admin_RequestsManagement', ['data' => $dataResult, 'status' => $status]);
    }
    
    public function  arrayPaginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function getUserAll($page)
    {
        $users = User::where('role', '=', TypeData::roleUser['user'])->paginate(10, ['*'], 'page', $page);
        $usersCount = User::where('role', '=', TypeData::roleUser['user'])->count();
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

            $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('status','0');");

            //get status == disable
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
//        dd($dataResult);
        return Inertia::render('NotiAdmin', ['noti' => $dataResult]);
    }

    public function orderDetail($service_id, $id)
    {
        $dataService = ServicesModel::find($service_id);
        $dataLabel = [];

        //array
        $dataServiceField = ServicesFieldsModel::where('services_id', $service_id)->get();

        $model_name = $dataService['model_name'];
        $data_model = eval("return \\App\\Models\\" . $model_name . "::find(" . $id . ");");

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
            return;
        }
        $data_model['label'] = $dataLabel;
        $data_model['service_name'] = $dataService['name'];

        // dd($data_model);
        return Inertia::render('RequestDetails', ['data' => $data_model]);
    }

    public function explodeFieldValue($data)
    {

        // $dataField = [];
        foreach ($data as $key => $value) {
            if (str_contains(explode(',', $value)[0], 'radio') || str_contains(explode(',', $value)[0], 'checkbox') || str_contains(explode(',', $value)[0], 'select')) {
                $id = explode(',', $value);
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
        $services = ServicesModel::all();
        $dataService = [];
        foreach ($services as $service) {
            $model_name = $service['model_name'];
            //get service user used
            $data_model = eval("return \\App\\Models\\" . $model_name . "::all()->where('user_id'," . $user_id . ");");
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