<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceFieldValueModel extends Model
{
    use HasFactory;
    protected $table = 'service_field_value';
    protected $primaryKey = 'id';
    protected $fillable = [
        'services_fields_id',
        'name',
    ];
    public function servicesFields() : BelongsTo
    {
        return $this->belongsTo(ServicesFieldsModel::class,'services_fields_id','id');
    }
}
