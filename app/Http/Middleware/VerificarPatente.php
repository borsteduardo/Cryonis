<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificarPatente
{
    /**
     * Handle an incoming request.
     * O uso do ...$patentesRequeridas permite passar várias patentes separadas por vírgula.
     */
    public function handle(Request $request, Closure $next, ...$patentesRequeridas): Response
    {
        $user = Auth::user();

        // 1. Verifica se não está logado
        if (!$user) {
            return redirect('/login');
        }

        // 2. O Conselheiro tem "Passe Livre" (Master Admin)
        if ($user->patente === 'Conselheiro') {
            return $next($request);
        }

        // 3. Verifica se a patente do usuário atual está na lista de patentes exigidas pela rota
        if (!in_array($user->patente, $patentesRequeridas)) {
            return redirect('/dashboard')->with('erro', 'Acesso restrito. Você não tem a patente necessária.');
        }

        return $next($request);
    }
}