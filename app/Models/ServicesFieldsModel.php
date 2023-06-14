<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
