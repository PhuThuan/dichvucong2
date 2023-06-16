<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class ServicesFieldsModel extends Model
{
    use HasFactory;
    protected $table = 'services_fields';
    protected $fillable = [
        'services_id',
        'field_name',
        'html_type',
        'db_type',
        'label',
        'validate',  
        'placeholder',    
   ];

    public function services() : BelongsTo
    {
        return $this->belongsTo(ServicesModel::class,'services_id','id');
    }

    public function serviceFieldValue() : HasMany
    {
        return $this->hasMany(ServiceFieldValueModel::class,'services_fields_id','id');
    }
}

