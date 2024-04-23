<?php

// app/Http/Middleware/CheckPatientExistence.php

namespace App\Http\Middleware\Checkers;

use Closure;
use App\Models\Patient;

class CheckPatientExistence
{
    public function handle($request, Closure $next)
    {
        $patient = Patient::find($request->id);

        if (!$patient) {
            abort(404, 'Patient not found');
        }

        return $next($request);
    }
}
