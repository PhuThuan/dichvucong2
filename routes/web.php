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
     [UserController::class,'getService']
)->name('dashboard');
Route::get('/contact',[UserController::class,'contact'])->name('contact');;





//middleware check account login is admin or user
Route::prefix('/admin')->middleware(['checkAccountLogin','auth','verified'])->group(function () {

    Route::get('/',function(){
        return Inertia::render('Home_Admin');
    });
    Route::get('/account', [AdminController::class,'getInfo'])->name('admin');

    Route::get('/manage/customer',function(){
        return Inertia::render('Customer_Management');
    });
    Route::resource('/service', ServiceController::class)->names(['store'=>'service.store']);

    
});

Route::middleware(['auth','verified'])->group(function () {
    
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';