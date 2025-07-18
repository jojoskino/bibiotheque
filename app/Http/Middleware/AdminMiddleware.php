<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous n\'avez pas les droits d\'administrateur.');
        }

        return $next($request);
    }
} 