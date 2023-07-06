<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GroupModel;
use Illuminate\Support\Facades\Artisan;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('migrate');

        
        \App\Models\GroupModel::create([
            'name' => 'admin',
            'permission' => '["sanctum/csrf-cookie","_ignition/health-check","_ignition/execute-solution","_ignition/update-config","api/user","/","contact","admin","admin/service","admin/service/create","admin/service/{service}","admin/service/{service}/edit","admin/service/list/{service_id}/{page?}/{status?}","admin/account/{page}","admin/notification","admin/order/detail/{service_id}/{id}","admin/manage/customer/{user_id}/service","admin/list/service","admin/serviceForm/{id_service}","admin/service/post/{id_service}","admin/setting/route","admin/setting/mail","admin/routing/{id}","admin/{slug?}","user","user/service","user/service/{id_service}","user/profile/service","user/order/detail/{service_id}/{id}","profile","get-address","get-noti","{slug?}","register","login","forgot-password","reset-password/{token}","reset-password","verify-email","verify-email/{id}/{hash}","email/verification-notification","confirm-password","password","logout"]'
        ]);

        GroupModel::create([
            'name' => 'customer',
            'permission' => '["sanctum/csrf-cookie","_ignition/health-check","_ignition/execute-solution","_ignition/update-config","api/user","/","contact","user","user/service","user/profile/service","user/order/detail/{service_id}/{id}","profile","get-address","get-noti","register","login","forgot-password","reset-password/{token}","reset-password","verify-email","verify-email/{id}/{hash}","email/verification-notification","confirm-password","password","logout"]',
        ]);

        \App\Models\User::factory()->create([
            
            'email' => 'admin@email.com',
            'password' => bcrypt('123456'),
            'role' => 1,
            'phone' => '0937411369',
            'gr_id' => GroupModel::where('name','admin')->first()['id'],

        ]);
        
    }
}