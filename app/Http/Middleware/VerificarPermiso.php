<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarPermiso
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permiso): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User|null $user */
        $user = Auth::user();

        if (! $user || ! method_exists($user, 'tienePermiso') || ! $user->tienePermiso($permiso)) {
            abort(403, 'No tienes los permisos necesarios para realizar esta acción.');
        }

        return $next($request);
    }
}
