<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ServicesModel extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $fillable = [
        'name',
        'model_name',
        'table_name',
        'slug',
        'description',
        'status',      
   ];

    public function servicesFields() : hasOne
    {
        return $this->hasOne(ServicesFieldsModel::class,'services_id','id');
    }

}
