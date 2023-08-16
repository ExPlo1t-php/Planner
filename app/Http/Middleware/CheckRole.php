<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('dashboard')->with('message', 'fool, idiot, moron');
        }

        $user = auth()->user();

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // abort(403, 'Unauthorized action.');
        return redirect()->route('dashboard')->with('message', 'non autorisé');
    }


}
