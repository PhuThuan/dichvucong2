<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function getEmail()
    {
        $data =
            [
                'MAIL_USERNAME' => env('MAIL_USERNAME'),
                'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
                'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
                'MAIL_HOST' => env('MAIL_HOST'),
                'MAIL_PORT' => env('MAIL_PORT')
            ];

        return Inertia::render('SettingEmail', ['settingEmail' => $data]);
    }
    public function storeEmail(Request $request)
    {
        config([
            'MAIL_USERNAME' => $request->input('MAIL_USERNAME') ?? env('MAIL_USERNAME'),
            'MAIL_ENCRYPTION' => $request->input('MAIL_ENCRYPTION') ?? env('MAIL_ENCRYPTION'),
            'MAIL_FROM_NAME' => $request->input('MAIL_FROM_NAME') ?? env('MAIL_FROM_NAME'),
            'MAIL_PASSWORD' => $request->input('MAIL_PASSWORD') ?? env('MAIL_PASSWORD'),
            'MAIL_HOST' => $request->input('MAIL_HOST') ?? env('MAIL_HOST'),
            'MAIL_PORT' => $request->input('MAIL_PORT') ?? env('MAIL_PORT'),
        ]);
        $data =
            [
                'MAIL_USERNAME' => env('MAIL_USERNAME'),
                'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
                'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
                'MAIL_HOST' => env('MAIL_HOST'),
                'MAIL_PORT' => env('MAIL_PORT')
            ];
        return Inertia::render('SettingEmail', ['settingEmail' => $data]);
    }
}
