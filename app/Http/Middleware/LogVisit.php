<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visit;

class LogVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next): Response
{
    if ($request->isMethod('get') && !$request->is('storage/*') && !$request->is('vendor/*')) {
        Visit::create([
            'ip_address' => $request->ip(),
            'page_visited' => $request->path() ?: 'accueil',
        ]);
    }

    return $next($request);
}

}
