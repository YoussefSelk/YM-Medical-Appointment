<?php

// app/Http/Middleware/CheckSpecialityExistence.php

namespace App\Http\Middleware\Checkers;

use Closure;
use App\Models\Speciality;

class CheckSpecialityExistence
{
    public function handle($request, Closure $next)
    {
        $speciality = Speciality::find($request->id);

        if (!$speciality) {
            abort(404, 'Speciality not found');
        }

        return $next($request);
    }
}
