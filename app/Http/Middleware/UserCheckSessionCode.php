<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserCheckSessionCode
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionHasPhone = $request
            ->session()
            ->has('phone');

        if (! $sessionHasPhone) {
            return redirect()
                ->route('auth.login');
        }

        return $next($request);
    }
}
