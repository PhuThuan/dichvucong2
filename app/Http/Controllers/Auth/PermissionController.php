<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GroupModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PermissionController extends Controller
{


    public function getUserPermission()
    {
        $data_group = GroupModel::all();
        $data_url = [];
        // Artisan::call('route:list');
        // return Artisan::output();
        $dataRoute = Route::getRoutes();

        foreach ($dataRoute as $data) {
           array_push($data_url,$data->uri) ;
        }
        //dd($dataRoute);
        $data_user=[];

        foreach (User::all() as $data) {
            array_push($data_user,$data['email']) ;
        }
        $data = [
            'group' =>  $data_group,
            'user' =>$data_user,
            'url' => $data_url,
        ];

        return Inertia::render('Permission',['data'=>$data]);
    }

    public function updateGroupPermission(Request $request){
        $gr = GroupModel::find($request->gr_id);
        $gr->permission = $request->permission;
        $gr->save();
        return to_route('setting_premission');
    }

    public function storeGroupPermission(Request $request){
        GroupModel::create(['name' => $request->name , 'permission' => '']);
    }

    public function updateRoleUser(Request $request){

        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();

        return to_route('detailUser',['user_id' => $request->user_id]);
    }
    // public function getCurrentPermission(Request $request){
        
    //     $currentGroup = GroupModel::where('id',$request->gr_id)->get();
    //     //dd($currentGroup);
    //     return Inertia::render('Permission',['currentGroup' => $currentGroup]);

    // }
}
