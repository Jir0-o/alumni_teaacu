<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'cips' => ['required', 'string', 'unique:' . User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $first = User::first();
        if ($first) {
            $user = User::create([
                'name' => $request->name,
                'cips' => $request->cips,
                'email' => $request->email,
                'status' => 1,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            $person = new Person;
            $person->id = $user->id;
            $person->user_id = $user->id;
            $person->name = $user->name;
            $person->status = 1;
            $person->save();

            $user->assignRole('Guest');
             
            Auth::login($user, true);

            return redirect()->intended('/profile-show');
        } 
        else {
            $user = User::create([
                'name' => $request->name,
                'cips' => $request->cips,
                'email' => $request->email,
                'status' => 1,
                'password' => Hash::make($request->password),
                'role' => 1,
            ]);
            event(new Registered($user));

            $person = new Person;
            $person->id = $user->id;
            $person->name = $user->name;
            $person->user_id = $user->id;
            $person->status = 1;
            $person->name = 'Person';
            $person->save();

            Auth::login($user);
    
            return redirect(RouteServiceProvider::HOME);
        }



    }
}
