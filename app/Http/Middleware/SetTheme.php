<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTheme
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('theme')) {
            session(['theme' => $request->theme === 'dark' ? 'dark' : 'light']);
            return redirect($request->url());
        }

        return $next($request);
    }
}
