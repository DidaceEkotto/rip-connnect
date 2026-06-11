<?php
// app/Http/Middleware/AuthenticateAdmin.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie UNIQUEMENT le guard admin — indépendant du guard web
        if (! Auth::guard('admin')->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()
                ->route('admin.login')
                ->with('error', 'Veuillez vous connecter en tant qu\'administrateur.');
        }

        // Vérifie si le compte admin est actif
        $admin = Auth::guard('admin')->user();

        if (! $admin->is_active) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->with('error', 'Votre compte administrateur est désactivé.');
        }

        return $next($request);
    }
}
