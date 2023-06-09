<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Enums\TypeData;
use App\Models\GroupModel;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
          
            'phone' => 'required|string|max:55|unique:'.User::class,
            'password' => ['required'],
            'password_confirmation'=>['required', 'same:password',],
        ]);
        //dd(GroupModel::where('name','customer')->first()['id']);
        $user = User::create([
            'phone' => $request->phone,
            'email' => $request->phone.'@asia.mail',
            'password' => Hash::make($request->password),
            'role' => TypeData::roleUser['user'],
            'gr_id' => GroupModel::where('name','customer')->first()['id'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
