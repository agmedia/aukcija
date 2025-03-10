<?php

namespace App\Http\Middleware;

use Bouncer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Bouncer::is(auth()->user())->an('customer')) {
            return redirect()->route('moj.racun');
        }

        return $next($request);
    }
}
