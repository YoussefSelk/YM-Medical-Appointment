<?php

// app/Http/Controllers/Auth/DoctorRegisteredUserController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Application;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;

class DoctorRegisteredUserController extends Controller
{
    /**
     * Show the doctor registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create($token)
    {
        $application = Application::where('registration_token', $token)->firstOrFail();
        $specialities = Speciality::all();
        return view('auth.doctor-register', ['token' => $token, 'application' => $application, 'specialities' => $specialities]);
    }


    /**
     * Handle an incoming registration request for doctor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    //XSS Attacks Functions
    private function isXssAttackDetected(array $originalInputs, array $sanitizedInputs): bool
    {
        foreach ($originalInputs as $index => $originalInput) {
            if ($originalInput !== $sanitizedInputs[$index]) {
                return true;
            }
        }
        return false;
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|string',
            'phone' => 'required|string',
            'birth_date' => 'required|date',
            'rue' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'speciality' => 'required|string|max:255',
            'token' => 'required|string',
        ]);

        $rawInput = [
            $request->name,
            $request->ville,
            $request->rue,
            $request->email,
            $request->degree,
            $request->speciality
        ];

        $sanitizedInput = [
            htmlspecialchars($validatedData['name']),
            htmlspecialchars($validatedData['ville']),
            htmlspecialchars($validatedData['rue']),
            htmlspecialchars($validatedData['email']),
            htmlspecialchars($validatedData['degree']),
            htmlspecialchars($validatedData['speciality'])
        ];

        if ($this->isXssAttackDetected($rawInput, $sanitizedInput)) {
            return redirect()->back()->with('error', 'XSS or SQL Injection attack detected. Please provide valid input.');
        }


        $address = Address::create([
            'ville' => $validatedData['ville'],
            'rue' => $validatedData['rue'],
        ]);

        if (!$address) {
            return redirect()->back()->with('error', 'Error creating the address. Please try again.');
        }

        $user = User::create([
            'name' => htmlspecialchars($validatedData['name']),
            'email' => htmlspecialchars($validatedData['email']),
            'password' => Hash::make($validatedData['password']),
            'user_type' => 'doctor',
            'gender' => $validatedData['gender'],
            'phone' => htmlspecialchars($validatedData['phone']),
            'address_id' => $address->id,
        ]);

        if (!$user) {
            $address->delete();
            return redirect()->back()->with('error', 'Error creating the user. Please try again.');
        }

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'birth_date' => $validatedData['birth_date'],
            'degree' => htmlspecialchars($validatedData['degree']),
            'specialty_id' => $validatedData['speciality'],
            'status' => 'active',
        ]);

        if (!$doctor) {
            $user->delete();
            $address->delete();
            return redirect()->back()->with('error', 'Error creating the doctor record. Please try again.');
        }

        auth()->login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
