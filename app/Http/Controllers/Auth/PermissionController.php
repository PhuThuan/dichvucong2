<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GroupModel;
use Illuminate\Http\Request;

class PermissionController extends Controller
{


    public function getUserPermission(){
        GroupModel::all();
        
    }
}
