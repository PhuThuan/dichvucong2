<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFieldValueModel extends Model
{
    use HasFactory;
    protected $table = 'service_field_value';
    protected $primaryKey = 'id';
    protected $fillable = [
        'services_fields_id	',
        'name',
    ];
}
