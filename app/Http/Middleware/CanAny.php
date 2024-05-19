<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanAny
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions) : Response
    {
        foreach ($permissions as $permission) {
            //strip any whitespace
            $permission = trim($permission);
            if ($request->user()->can($permission)) {
                return $next($request);
            }
        }
        abort(403, 'আপনার এই কাজটি করার অনুমতি নেই।');
    }
}