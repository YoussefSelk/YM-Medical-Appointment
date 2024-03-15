<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
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
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::PATIENT_HOME);
    // }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cin' => ['required', 'numeric'],
            'birth_date' => ['required', 'date'],
            'rue' => ['required', 'string'],
            'ville' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
        ]);



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'phone' => $request->phone,
            'user_type' => 'patient', // Assuming you're distinguishing users by types
        ]);

        if ($user) {
            $patient = Patient::create([
                'cin' => $request->cin,
                'birth_date' => $request->birth_date,
                'user_id' => $user->id,
            ]);
            if ($patient) {
                $address = $user->address()->create([
                    'rue' => $request->rue,
                    'ville' => $request->ville,
                ]);
                if ($address) {
                    event(new Registered($user));

                    Auth::login($user);

                    return redirect(RouteServiceProvider::PATIENT_HOME);
                } else {
                    $user->delete();
                    $patient->delete();
                    $address->delete();
                    return redirect()->back()->with('error', 'Something went wrong');
                }
            } else {
                $user->delete();
                $patient->delete();
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            $user->delete();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
