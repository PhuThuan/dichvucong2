<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Admin\Service\ServiceFieldsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Auth\PermissionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

///
Route::get(
    '/',
    // return Inertia::render('Dashboard', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
    [UserController::class, 'getService']
)->name('dashboard');

Route::get('/contact', [UserController::class, 'contact'])->name('contact');;





//middleware check account login is admin or user
Route::prefix('/admin')->middleware(['checkAccountLogin', 'auth', 'verified','permission'])->group(function () {

    Route::get('/', function () {
        return Inertia::render('Admin_Home');
    });
    //   Route::get('/account', [AdminController::class,'getInfo'])->name('admin');
    // Route::get('/manage/customer/{page}/{perPage}', [UserController::class, 'showDataCustomer'])->name("adminService");

    Route::resource('/service', ServiceController::class)->names(['store' => 'service.store']);

    Route::get('/service/list/{service_id}/{page?}/{status?}', [AdminController::class, 'getDataUsers']);

    route::get('/account/{page}', [AdminController::class, 'getUserAll']);

    route::get('/notification', [AdminController::class, 'notification'])->name('adminNoti');

    route::get('/order/detail/{service_id}/{id}', [AdminController::class, 'orderDetail'])->name('orderdetail');

    //chi tiet tk 
    route::get('/manage/customer/{user_id}/service', [AdminController::class, 'getUserService'])->name('detailUser');

    route::post('/manage/customer/{user_id}/service', [AdminController::class, 'storeUserInfo'])->name('sendDetailUser');

    route::put('/manage/customer/{user_id}/service', [PermissionController::class, 'updateRoleUser'])->name('updateUserDetail');

    route::get('/list/service', [AdminController::class, 'getListService']);

    Route::get('/serviceForm/{id_service}', [AdminController::class, 'getForm'])->name('createAdmin');

    Route::post('/service/post/{id_service}', [AdminController::class, 'createDataUser'])->name('dataForm');

    route::post('/order/detail/{service_id}/{id}', [AdminController::class, 'updateStatus']);
//
    route::get('/setting/route',[PermissionController::class, 'getUserPermission'])->name('setting_premission');

    route::put('/setting/route',[PermissionController::class, 'updateGroupPermission'])->name('update_setting_premission');

    //route::post('/setting/current_permission',[PermissionController::class,'getCurrentPermission'])->name('get_current_permission');

    route::post('/setting/route',[PermissionController::class, 'storeGroupPermission'])->name('store_setting_premission');
//
    route::post('/setting/mail',[SettingController::class, 'storeEmail'])->name('mail_setting');

    route::get('/routing/{id}',[PermissionController::class, 'getRoute']);

    //route::post('/routing/{id}',[PermissionController::class, 'storePermissionRoute']);

    route::get('/{slug?}', function (){
        return Inertia::render('Error');
    })->name('Error');
    
});

Route::prefix('/user')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Home_Admin');
    });

    Route::get('/service', [UserController::class, 'showService']);

    Route::get('/service/{id_service}', [UserController::class, 'getDataForm'])->name('createService');

    Route::post('/service/{id_service}', [UserController::class, 'createDataUser']);
    //chi tiet tai khoan
    route::get('/profile/service', [UserController::class, 'getUserService']);

    route::get('/order/detail/{service_id}/{id}', [UserController::class, 'orderDetail'])->name('order');
});


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/get-address', function () {
    // Lấy địa chỉ từ file trên github
    // $data = file_get_contents('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json');

    // Lấy địa chỉ từ File public/datas/addressData.json
    $json = File::get(public_path('datas/addressData.json'));
    return response($json)->header('Content-Type', 'application/json');
});
Route::get('/get-noti', [AdminController::class, 'notihead']);


// route::get('/{slug?}', function (){
//     return Inertia::render('Error');
// });
require __DIR__ . '/auth.php';