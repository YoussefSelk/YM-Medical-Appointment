<?php

// app/Http/Middleware/CheckDoctor.php

namespace App\Http\Middleware\Checkers;

use Closure;
use Illuminate\Http\Request;
use App\Models\Doctor;

class CheckDoctor
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the doctor exists
        if (!Doctor::find($request->id)) {
            abort(404, 'Doctor not found');
        }

        return $next($request);
    }
}
