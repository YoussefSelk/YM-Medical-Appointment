<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Valider les données et appliquer des règles de validation personnalisées
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Vérifier si les données validées contiennent des scripts malveillants
        if ($this->containsScript($validated['current_password']) || $this->containsScript($validated['password'])) {
            throw ValidationException::withMessages(['error' => 'XSS attack detected. Please provide valid input.']);
        }

        // Mettre à jour le mot de passe de l'utilisateur
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    private function containsScript($value)
    {
        // Vérifier si la valeur contient des balises de script
        return preg_match('/<\s*script.*script\s*>/i', $value);
    }
}
