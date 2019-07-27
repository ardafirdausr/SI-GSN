<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->wantsJson()
                    ? $request->header('Accept-Language') ?? 'id'
                    : $request->cookie('language') ?? 'id';
        // set laravel localization
        app()->setLocale($locale);
        // continue request
        return $next($request);
    }
}
