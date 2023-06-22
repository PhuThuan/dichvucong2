<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Service\ServiceController;
use App\Http\Controllers\Admin\Service\ServiceFieldsController;
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
Route::get('/',
    // return Inertia::render('Dashboard', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
     [UserController::class,'getService'])->name('dashboard');

Route::get('/contact',[UserController::class,'contact'])->name('contact');;





//middleware check account login is admin or user
Route::prefix('/admin')->middleware(['checkAccountLogin','auth','verified'])->group(function () {

    Route::get('/',function(){
        return Inertia::render('Admin_Home');
    });
 //   Route::get('/account', [AdminController::class,'getInfo'])->name('admin');
    Route::get('/manage/customer/{page}/{perPage}', [UserController::class, 'showDataCustomer'])->name("adminService");
    Route::resource('/service', ServiceController::class)->names(['store'=>'service.store']);

    Route::get('/service/list/{status}/{perPage}',[AdminController::class, 'getDataUsers']);
    route::get('/account/{page}',[AdminController::class,'getUserAll']);
    route::get('/notification',[AdminController::class,'notification'])->name('adminNoti');
    route::get('/order/detail/{service_id}/{id}',[AdminController::class,'oderDetail'])->name('orderdetail');
    route::get('/user/detail/{id}');
});

Route::prefix('/user')->middleware(['auth','verified'])->group(function () {
    Route::get('/',function(){
        return Inertia::render('Home_Admin');
    });

    Route::get('/service', [UserController::class,'showService']);

    Route::get('/service/{id_service}', [UserController::class,'getDataForm'])->name('createService');

    Route::post('/service/{id_service}', [UserController::class,'createDataUser']);

});


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::get('/order', function () {
    return Inertia::render('OrderCreateForm');
});

Route::get('/test/customer/{page}/{perPage}', [UserController::class, 'showDataCustomer']);
Route::get('/get-address', function () {
    // Lấy địa chỉ từ file trên github
    // $data = file_get_contents('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json');

    // Lấy địa chỉ từ File public/datas/addressData.json
    $json = File::get(public_path('datas/addressData.json'));
    return response($json)->header('Content-Type', 'application/json');
});

require __DIR__.'/auth.php';