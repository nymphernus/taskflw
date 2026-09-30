<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang')) {
            $lang = in_array($request->lang, ['ru', 'en']) ? $request->lang : 'ru';
            session(['locale' => $lang]);
            app()->setLocale($lang);
            return redirect($request->url());
        }

        if (session('locale')) {
            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
