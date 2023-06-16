<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Models\ServicesModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\TypeData;
use App\Models\ServiceFieldValueModel;
use App\Models\ServicesFieldsModel;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return Inertia::render('FormService');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $dataService = [
            'name' => $request->input('name'),
            'model_name' => $request->input('model_name'),
            'table_name' => $request->input('table_name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'status' => $request->input('status'),
        ];

        $dataField = $request->input('fields');
        //result store data about id service_id
        $result = ServicesModel::create($dataService);

        
        //dd($dataField);
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
           
        }

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
