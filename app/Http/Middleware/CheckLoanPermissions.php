<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLoanPermissions
{
    /**
     * Gère une requête entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Si l'utilisateur est un administrateur, il a tous les droits
        if (auth()->user()->is_admin) {
            return $next($request);
        }

        // Pour les autres utilisateurs
        if ($request->route('loan')) {
            $loan = $request->route('loan');

            // L'utilisateur ne peut voir que ses propres emprunts
            if ($loan->user_id !== auth()->id()) {
                abort(403, 'Vous n\'êtes pas autorisé à accéder à cet emprunt.');
            }

            // L'utilisateur ne peut pas valider ou retourner ses propres emprunts
            if (in_array($request->route()->getName(), ['loans.approve', 'loans.return'])) {
                abort(403, 'Vous n\'êtes pas autorisé à effectuer cette action.');
            }
        }

        return $next($request);
    }
} 