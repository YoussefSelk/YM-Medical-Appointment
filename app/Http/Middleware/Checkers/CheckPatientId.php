<?php

// app/Http/Middleware/CheckPatientId.php

namespace App\Http\Middleware\Checkers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPatientId
{
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated patient
        $authenticatedPatient = authUser()->patient;

        // Check if the authenticated patient's ID matches the ID in the URL
        if ($authenticatedPatient->id != $request->id) {
            abort(404);
        }

        return $next($request);
    }
}
