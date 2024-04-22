<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
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

    private function isXssAttackDetected(array $originalInputs, array $sanitizedInputs): bool
    {
        foreach ($originalInputs as $index => $originalInput) {
            if ($originalInput !== $sanitizedInputs[$index]) {
                return true; // XSS attack detected
            }
        }
        return false; // No XSS attack detected
    }
    public function store(Request $request): RedirectResponse
    {

        $originalName = $request->input('name');
        $originalVille = $request->input('ville');
        $originalRue = $request->input('rue');
        $originalEmail = $request->input('email');
        $originalPassword = $request->input('password');



        $name = htmlspecialchars($request->input('name'));
        $birthdate = $request->input('birth_date');
        $ville = htmlspecialchars($request->input('ville'));
        $rue = htmlspecialchars($request->input('rue'));
        $email = htmlspecialchars($request->input('email'));
        $password = htmlspecialchars($request->input('password'));
        $phone = htmlspecialchars($request->input('phone'));
        $gender = $request->input('gender');

        if ($this->isXssAttackDetected([$originalName, $originalVille, $originalRue, $originalEmail, $originalPassword], [$name, $ville, $rue, $email, $password])) {
            return redirect()->back()->with('error', 'XSS Or Sql Injection attack detected. Please provide valid input.');
        }

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

        $address = Address::create([
            'rue' => $request->rue,
            'ville' => $request->ville,
        ]);

        if ($address) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'phone' => $request->phone,
                'address_id' => $address->id,
                'user_type' => 'patient', // Assuming you're distinguishing users by types
            ]);
            if ($user) {
                $patient = Patient::create([
                    'cin' => $request->cin,
                    'birth_date' => $request->birth_date,
                    'user_id' => $user->id,
                ]);
                if ($patient) {
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
                $address->delete();
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            $address->delete();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
