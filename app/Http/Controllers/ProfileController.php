<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    private function isXssAttackDetected(array $originalInputs, array $sanitizedInputs): bool
    {
        foreach ($originalInputs as $index => $originalInput) {
            if ($originalInput !== $sanitizedInputs[$index]) {
                return true;
            }
        }
        return false;
    }
    public function img(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        // Check if the request has a file attached
        if ($request->hasFile('img')) {
            // Get the uploaded file
            $image = $request->file('img');

            // Generate a unique filename for the image
            $imageName = uniqid('profile_img_') . '.' . $image->getClientOriginalExtension();

            // Delete old profile image if it exists
            if ($request->user()->img) {
                Storage::disk('public')->delete('profile_pictures/' . $request->user()->img);
            }

            // Store the image in the public storage directory
            $image->storeAs('public/profile_pictures', $imageName);

            // Update the user's profile image path in the database
            $request->user()->update(['img' => $imageName]);

            // Redirect back with success message
            return redirect()->back()->with('status', 'Profile picture uploaded successfully.');
        }

        // If no file is attached or upload fails, redirect back with error message
        return redirect()->back()->with('error', 'Failed to upload profile picture.');
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Escape data before saving it to the database
        $safeData = array_map('htmlspecialchars', $validatedData);

        $user = $request->user();
        $user->fill($safeData);

        // Check for XSS attacks
        if ($this->isXssAttackDetected($validatedData, $safeData)) {
            return redirect()->back()->with('error', 'XSS Or Sql Injection attack detected. Please provide valid input.');
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        if ($request->filled('gender')) {
            $user->gender = htmlspecialchars($request->input('gender'));
        }

        if ($request->filled('phone')) {
            $user->phone = htmlspecialchars($request->input('phone'));
        }

        $user->save();

        if ($user->address && ($request->filled('ville') || $request->filled('rue'))) {
            if ($request->filled('ville')) {
                $user->address->ville = htmlspecialchars($request->input('ville'));
            }

            if ($request->filled('rue')) {
                $user->address->rue = htmlspecialchars($request->input('rue'));
            }

            $user->address->save();
        }

        // Update patient's information if the user type is 'patient'
        if ($user->user_type === 'patient' && $user->patient) {
            $patient = $user->patient;

            if ($request->filled('cin')) {
                $patient->cin = htmlspecialchars($request->input('cin'));
            }

            if ($request->filled('birth_date')) {
                $patient->birth_date = $request->input('birth_date');
            }

            $patient->save();
        }

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }




    private function containsScript($value)
    {
        // Vérifier si la valeur contient des balises de script
        return preg_match('/<\s*script.*script\s*>/i', $value);
    }

    public function deleteProfilePicture(Request $request)
    {
        // Check if the user has a profile picture
        if ($request->user()->img) {
            // Delete profile picture from storage
            Storage::disk('public')->delete('profile_pictures/' . $request->user()->img);

            // Update user's img column to null
            $request->user()->img = null;
            $request->user()->save();

            return redirect()->back()->with('status', 'profile-picture-deleted');
        }

        return redirect()->back()->with('error', 'No profile picture found.');
    }

    function isSqlInjection($value)
    {
        // Recherche de motifs ressemblant à des instructions SQL potentielles
        $sqlKeywords = array('SELECT', 'INSERT', 'UPDATE', 'DELETE', 'DROP', 'ALTER', 'CREATE', 'UNION', 'TRUNCATE', 'EXEC');
        $pattern = '/\b(' . implode('|', $sqlKeywords) . ')\b/i';

        // Vérifier si la chaîne de caractères contient des motifs d'injection SQL
        return preg_match($pattern, $value);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        if ($user->user_type === 'patient' && $user->patient) {
            $patient = Patient::find($user->patient->id);
            if ($patient && $patient->user) {
                $patientUser = User::find($patient->user->id);
                $address = $patient->user->address;
                $appointments = Appointment::where('patient_id', $patient->id)->get();
                if ($appointments->isNotEmpty()) {
                    $appointments->each->delete();
                }
                $patient->delete();
                if ($patientUser) {
                    $patientUser->delete();

                    if ($address) {
                        $address->delete();
                    }
                }
            }
        } else if ($user->user_type === 'doctor' && $user->doctor) {
            $doctor = Doctor::find($user->doctor->id);
            if ($doctor) {
                $address = $user->address;
                $schedules = Schedule::where('doctor_id', $doctor->id)->get();

                if ($schedules->isNotEmpty()) { // Check if there are schedules to delete
                    $schedules->each->delete(); // Delete each schedule
                }

                $doctor->delete();
                if ($user) {
                    $user->delete();

                    if ($address) {
                        $address->delete();
                    }
                }
            }
        } else {
            $user->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
