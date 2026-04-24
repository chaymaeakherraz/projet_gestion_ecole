<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthEtudiant
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('etudiant_id')) {
            // بدل redirect بـ abort
            abort(403, 'Accès non autorisé. Veuillez vous connecter.');
        }

        return $next($request);
    }
}
