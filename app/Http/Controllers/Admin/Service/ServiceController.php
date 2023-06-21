<?php

namespace App\Http\Controllers\Admin\Service;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use App\Models\ServicesModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\TypeData;
use App\Http\Requests\FormServiceRequest;
use App\Models\ServiceFieldValueModel;
use App\Models\ServicesFieldsModel;
use App\Models;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ServicesModel::all();
        return Inertia::render('Admin_Managerment_Services', ['services' => $data]);
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('FormService');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormServiceRequest $request)
    {
       dd($request->all());
        $dataService = [
            'name' => $request->input('name'),
            'model_name' => $request->input('model_name'),
            'table_name' => $request->input('table_name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ];

        //////////check Model///////////
        $model_name = $dataService['model_name'];
        $table_name = $dataService['table_name'];
        $getFieldData = [];

        if($this->checkModelExists($model_name)){
            
           return back()->with('notification','Model đã tồn tại');

        }else {
           
            //dd($dataField);
            $dataField = $request->input('fields');
            //result store data about id service_id
            $result = ServicesModel::create($dataService);

            foreach($dataField as $value){
                $data = [
                    'services_id' => $result->id,
                    'field_name' => $value['field_name'],
                    'html_type' => $value['html_type'],
                    'db_type' => $value['db_type'],
                    'label' => $value['label'],
                    'validate' => $value['validate'],
                    'placehoder' => $value['placehoder'],
                    
                ];
                $temp  = [
                    'field_name' => $data['field_name'],
                    'db_type' => $data['db_type'],
                ];
                array_push($getFieldData,$temp);
                
                //store data array values option
                $fileds_value = $value['fields_value'] ?? [];
                //1 row = 1 object
                $dataFieldValue = ServicesFieldsModel::create($data);

                //handle multi type
                if($dataFieldValue['html_type'] == TypeData::htmlType['radio'] || $dataFieldValue['html_type'] == TypeData::htmlType['checkbox'] || $dataFieldValue['html_type'] == TypeData::htmlType['select']){
                    //get data field_value from FE = array values option, exmaple ['male', 'female]
                    $service_field_value = $fileds_value;

                        foreach($service_field_value as $value){
                            $data = [
                                'services_fields_id' => $dataFieldValue['id'],
                                'name' => $value,
                            ];
                            ServiceFieldValueModel::create($data);
                        }

                }
            
            }//end loop
            //dd($getFieldData);
            $this->createModel($getFieldData ,$model_name,$table_name);
            return back()->with('notification','Tạo dịch vụ thành công');
        }
    }

    public function createModel($data,$model_name,$table_name){
        
        $migrate_call = '';
        $model_call = '';
        //dd($data);
        $dataRequire = [
            [
                'field_name' => 'service_id',
                'db_type' => TypeData::dbType['int']
            ],
            [
               'field_name' => 'user_id',
               'db_type' => TypeData::dbType['int']

            ],
            [
                'field_name' => 'status',
                'db_type' => TypeData::dbType['boolean']
            ]
        ];
        //add required data
        foreach($dataRequire as $value){
            array_push($data,$value);
        }
       
       // dd($data);
        foreach($data as $value){
            
            //dd($value);
            $migrate_call .= ($value['field_name'] . '#' . TypeData::dbType[$value['db_type']] . ';');
            $model_call .= ('\'' .$value['field_name']. '\'' . ',' );
            
        }
        //add required data
        //$migrate_call .='service_id#'. TypeData::dbType['int'].';user_id#'. TypeData::dbType['int'].';status#'. TypeData::dbType['boolean'];
        
        //exm php artisan crud:migration posts --schema="title#string; body#text"
        Artisan::call("crud:migration ".$table_name." --schema=". $migrate_call);
        //run migrate
        Artisan::call('migrate');
        //step 2 call model
        //exm php artisan crud:model Post --fillable="['title', 'body']"
        Artisan::call("crud:model ".$model_name." --relationships=\"user_id\"#hasMany#App\Models\User --table=\"$table_name\" --fillable=\"[".$model_call."]\" ");
        //rename model to Models/
        rename(app_path($model_name.'.php'),app_path('Models/'.$model_name.'.php'));

    }
    public function checkModelExists($model_name){
        
        if(file_exists(app_path('/Models/'.$model_name.'.php'))){
            
            return true;

        }
        else return false;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
